<?php

class Database
{

    private $connection;

    private $host;
    private $username;
    private $password;
    private $database;
    private $port;
    private $socket;

    private $errorFilepath;

    public function __construct ($config=null)
    {
        $c = $config;
        if (!empty($config) && is_array($config)) {
            $this->host = isset($c['host']) ? $c['host'] : '';
            $this->username = isset($c['username']) ? $c['username'] : '';
            $this->password = isset($c['password']) ? $c['password'] : '';
            $this->database = isset($c['database']) ? $c['database'] : '';
            $this->port = isset($c['port']) ? $c['port'] : '';
            $this->socket = isset($c['socket']) ? $c['socket'] : '';
        } else {
            $this->host = DATABASE_HOST;
            $this->username = DATABASE_USERNAME;
            $this->password = DATABASE_PASSWORD;
            $this->database = DATABASE_DATABASE;
            $this->port = DATABASE_PORT;
            $this->socket = DATABASE_SOCKET;
        }

        $this->connection = null;

        $filepath = DIR_LIBRARY.DS.'logs'.DS.'db_errors.php';
        $this->errorFilepath = file_exists($filepath) ? $filepath : null;
    }



    public function __destruct ()
    {
        
    }



    private function displayError ($errorType)
    {
        switch ($errorType) {
            case 'missing':
                break;
        }
    }



    private function connect ()
    {
        try {
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->database.';charset=utf8';
            $opt = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH
                );
            $this->connection = new PDO(
                    $dsn,
                    $this->username,
                    $this->password,
                    $opt
                );
        } catch (PDOException $e) {
            $this->logDbError('Cannot connect to the database with PDO.'.PHP_EOL.'PDO Connection failed.');
            exit('Fatal Error: The system failed to connect to the database.<br />Please contact your System Administrator to fix this problem.<br />Exiting...');
        }
    }



    private function disconnect ()
    {
        $this->connection = null;
    }



    public function statement ($sqlQuery, $sqlValues=array())
    {
        if (!($this->connection instanceof PDO)) {
            $this->connect();
        }

        $connection = $this->connection;

        if (isset($sqlQuery) && !empty($sqlQuery)) {
            $query = trim($sqlQuery);
        } else {
            $this->logDbError('SQL Query is empty.');
            return false;
        }

        $isSqlValuesValid = isset($sqlValues) && is_array($sqlValues);
        $values = $isSqlValuesValid ? $sqlValues : array();

        // Prepare Statement
        try {
            $statement = $connection->prepare($query);

            if (!$statement) {
                throw new PDOException('PDOException: Failed to prepare the query.');
            }
        } catch (PDOException $e) {
            $this->logDbError($e->getMessage().PHP_EOL.PHP_EOL.'
                SQL Query: '.$query);
        }

        // Binding Parameters
        if (is_array($values)) {
            $ph = 0; // Placeholder

            foreach ($values as $value) {
                if (gettype($value) == 'integer') {
                    $type = PDO::PARAM_INT;
                } else {
                    $type = PDO::PARAM_STR;
                }
                $ph++;

                // PDO method `bindValue` is expected to return
                // true on success and false on failure
                $status = $statement->bindValue($ph, $value, $type);

                if (!$status) {
                    $this->logDbError('Failed to bind parameter.'.PHP_EOL.'
                        Placeholder: '.$ph.PHP_EOL.'
                        Value: '.$value);
                }
            }
        }

        // Execution of Statement
        try {
            $queryType = explode(' ', $query);
            $queryType = $queryType[0];
            $array1 = array(
                    'SELECT',
                    'SHOW'
                );
            $array2 = array(
                    'INSERT',
                    'UPDATE',
                    'DELETE'
                );

            if (in_array($queryType, $array1)) {
                $array = array();
                $statement->execute();
                $statement->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $statement->fetch()) {
                    array_push($array, $row);
                }
                return $array;
            } else if (in_array($queryType, $array2)) {
                // The expected return value is either
                // true or false
                return $statement->execute();
            } else {
                $this->logDbError('Unknown type of SQL statement.');
            }
        } catch (PDOException $e) {
            $this->logDbError('Failed in executing the statement.'.PHP_EOL.PHP_EOL.'SQL Query: '.$query.PHP_EOL.PHP_EOL.'Reason: '.$e->getMessage());
        }
    }



    public function lastInsertId ()
    {
        if ($this->connection instanceof PDO) {
            return $this->connection->lastInsertId();
        } else {
            return null;
        }
    }



    public function displayDbErrors ()
    {
        $file = $this->errorFilepath;

        if ($file === null) {
            exit('Fatal Error: Your log file for database errors is missing.<br />
                Please create your log file `db_errors.php` on this directory `root/library/logs/db_errors.php`<br />
                Thank you.<br /><br />
                <a href="'.URL_BASE.'">Click here</a> to go back to the Homepage.');
        }

        $core = new SystemCore();

        $content = file_get_contents($file);
        if (!unserialize($content)) {
            $content = array();
        } else {
            $content = unserialize($content);
        }

        if (!is_array($content)
                || count($content) < 1) {
            echo 'No error/s have been logged as of the moment.
                <div class="hr-light"></div>
                <a href="'.URL_BASE.'admin/logs/database_errors/display/"><input type="button" value="Refresh" /></a>';
            return;
        }

        if (count($content) > 0) {
            krsort($content);
        }

        $logContent = '';
        foreach ($content as $i => $c) {
            $logContent .= '<tr>
                <td>'.$i.'</td>
                <td>'.$core->transformDate($c['date']).' @ '.$c['time'].'</td>
                <td>'.$c['user'].'</td>
                <td>'.nl2br($c['details']).'</td>
                </tr>';
        }

        $htmlOutput = '<table><tr>
            <th>No.</th>
            <th>Date and Time</th>
            <th>Logged User</th>
            <th>Details</th>
            </tr>
            '.$logContent.'
            </table>
            <div class="hr-light"></div>
            <a href="'.URL_BASE.'admin/logs/database_errors/display/"><input type="button" value="Refresh" /></a>
            <a href="'.URL_BASE.'admin/logs/database_errors/clean/"><input class="btn-red" type="button" value="Clean Database Errors Log" /></a>';

        echo $htmlOutput;
    }



    private function logDbError ($details)
    {
        $file = $this->errorFilepath;

        if ($file === null) {
            echo 'FATAL ERROR: Database encountered an error and your log file for these type of errors is missing.<br />
                Please create your log file `db_errors.php` on this directory `root/library/logs/db_errors.php`<br />
                The database error you have encountered was not logged.<br /><br />
                Thank you.<br />
                Exiting...<br /><br />
                <a href="',URL_BASE,'">Click here</a> to go back to the Homepage.';
            exit();
        }

        $content = file_get_contents($file);

        if (unserialize($content) !== false) {
            $content = unserialize($content);
            if (!is_array($content)) {
                $content = array();
            }
        } else {
            $content = array();
        }

        if (isset($_SESSION['user'])) {
            $username = $_SESSION['user']['username'];
            $name = $_SESSION['user']['name'];
            $loggedUser = $username.' <> '.$name;
        } else {
            $loggedUser = 'There are no user that are logged-in into the system.';
        }

        $error = array(
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'user' => $loggedUser,
            'details' => $details);

        array_push($content, $error);
        $content = serialize($content);
        $logSuccess = file_put_contents($file, $content);

        if (!$logSuccess) {
            echo 'FATAL ERROR: The system failed to write the database error into its log file.<br /><br />
                Exiting...<br /><br />
                <a href="',URL_BASE,'">Click here</a> to go back to the Homepage.';
            exit();
        }
    }



    public function cleanDbErrors ()
    {
        $file = $this->errorFilepath;
        if ($file === null) {
            exit($this->errorFileMessages['missing']);
        }
        file_put_contents($file, '');
        $contents = file_get_contents($file);
        if (strlen(trim($contents)) > 0) {
            exit('System Error: The system failed to clean the database log file.<br />Exiting...<br /><br /><a href="'.URL_BASE.'admin/logs/database_errors/">Click here</a> to go back.');
        }
        header('location: '.URL_BASE.'admin/logs/database_errors/display/');
    }



    public function displayLog ()
    {

    }



    public function cleanLog ()
    {

    }



    private function addLog ($details)
    {
        $filepath = $this->errorFilepath;
        if ($filepath === null) {
            exit();
        }

        if (!empty($_SESSION['user'])) {
            $userUsername = $_SESSION['user']['username'];
            $userName = $_SESSION['user']['name'];
            $user = $userUsername.' <account of> '.$userName;
        } else {
            $user = 'No logged-in user in the system.';
        }
        $datetime = date('Y-m-d H:i:s');
        $logContent = array(
                'datetime' => $datetime,
                'user' => $user,
                'details' => $details
            );
    }



    protected function getEnum ($tableName, $fieldName)
    {
        $query = "SHOW COLUMNS FROM $tableName";
        $results = $this->statement($query);
        if (count($results) > 0) {
            $enum = '';
            foreach ($results as $result) {
                if ($result['Field'] == $fieldName) {
                    $enum = $result['Type'];
                    break;
                }
            }
            $pattern = '/(enum\(\'|\'\))/';
            $enum = preg_replace($pattern, '', $enum);
            $enum = explode('\',\'', $enum);
            return $enum;
        } else {
            return null;
        }
    }



    protected function dbSelectOptions (
        $tableName,
        $fieldName,
        $type='enum'
    ) {
        $defaultArray = array(
                'Option 1' => 'Option 1',
                'Option 2' => 'Option 2'
            );
        switch ($type) {
            case 'enum':
                $array = $this->getEnum($tableName, $fieldName);
                return is_array($array) ? $array : $defaultArray;
                break;

            case 'table':
                $fieldName = explode(', ', $fieldName);
                if (count($fieldName) !== 2) {
                    echo 'Program Error: invalid use of method dbSelectOptions.<br />Please notify your System Administrators regarding this error.';
                }
                $label = $fieldName[0];
                $value = $fieldName[1];

                $query = "SELECT $label, $value FROM $tableName
                    ORDER BY $label ASC";
                $results = $this->statement($query);
                if (count($results) > 0) {
                    $array = array();
                    foreach ($results as $result) {
                        $array[$result[$label]] = $result[$value];
                    }
                    return $array;
                } else {
                    return $defaultArray;
                }
                break;

            default:
                echo 'Program Error: Class Database, Method dbSelectOptions, is not used properly.<br />Unknown type of Select Options to generate.';
        }
    }

}
