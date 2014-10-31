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

    protected $errorFilepath;

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

        $filepath = DIR_LOGS.DS.'database.php';
        if (file_exists($filepath)) {
            $this->errorFilepath = $filepath;
        } else {
            exit('Fatal Error: Your database log file, '.$filepath.', is missing.<br />Please contact your System Administrators to fix this problem.<br />Exiting...');
        }
    }



    public function __destruct ()
    {
        
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
            $this->addLog('Fatal Error: PDO cannot connect to the database'.PHP_EOL.'Please check your database configurations.');
            exit('Fatal Error: The system failed to connect to the database.<br />Please contact your System Administrators to fix this problem.<br />Exiting...');
        }
    }



    private function disconnect ()
    {
        $this->connection = null;
    }



    protected function statement ($sqlQuery, $sqlValues=array())
    {
        if (
            !($this->connection instanceof PDO) ||
            $this->connection === null
        ) {
            $this->connect();
        }

        $connection = $this->connection;

        if (isset($sqlQuery) && !empty($sqlQuery)) {
            $query = trim($sqlQuery);
        } else {
            $this->addLog('Program Error: SQL Query is empty.');
            return null;
        }

        $cond = isset($sqlValues) && is_array($sqlValues);
        $values = $cond ? $sqlValues : array();

        // Prepare PDO statement
        try {
            $statement = $connection->prepare($query);
            if (!$statement) {
                throw new PDOException('Fatal Error: The system failed to prepare the Query.');
            }
        } catch (PDOException $e) {
            $this->addLog($e->getMessage().PHP_EOL.PHP_EOL.
                'SQL Query: '.$query);
            exit('Fatal Error: The query, '.$query.', failed to be prepared by the system.<br />
                Please contact your System Administrators to fix this problem.<br />
                <a href="'.URL_BASE.'">Click here</a> to go back to the Homepage.<br />
                Exiting...');
        }

        // Bind values
        if (is_array($values) && !empty($values)) {
            $placeholder = 0;
            foreach ($values as $value) {
                $cond = gettype($value) === 'integer';
                $type = $cond ? PDO::PARAM_INT : PDO::PARAM_STR;
                $placeholder++;

                // Expected return value is true or false
                $status = $statement->bindValue(
                        $placeholder,
                        $value,
                        $type
                    );

                if (!$status) {
                    $this->addLog('Fatal Error: The system failed to bind the value of the parameter.'.PHP_EOL.PHP_EOL.
                        'Placeholder: '.$placeholder.PHP_EOL.
                        'Value: '.$value);
                }
            }
        }

        // Execution of Statement
        try {
            $queryType = explode(' ', $query);
            $queryType = $queryType[0];
            $array1 = array('SELECT', 'SHOW');
            $array2 = array('INSERT', 'UPDATE', 'DELETE');
            if (in_array($queryType, $array1)) {
                $array = array();
                $statement->execute();
                $statement->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $statement->fetch()) {
                    array_push($array, $row);
                }
                return !empty($array) ? $array : null;
            } else if (in_array($queryType, $array2)) {
                return $statement->execute();
            } else {
                $this->addLog('Program Error: The system do not recognize the type of the query.'.PHP_EOL.PHP_EOL.
                    'Query Type: '.$queryType.PHP_EOL.
                    'SQL Query: '.$query);
            }
        } catch (PDOException $e) {
            $this->addLog('System Error: The system failed to execute the PDO statement.'.PHP_EOL.PHP_EOL.
                'SQL Query: '.PHP_EOL.$query.PHP_EOL.PHP_EOL.
                'Values: '.PHP_EOL.print_r($values, true).PHP_EOL.PHP_EOL.
                'Reason: '.PHP_EOL.$e->getMessage());
        }
    }



    protected function lastInsertId ()
    {
        $cond = $this->connection instanceof PDO;
        return $cond ? $this->connection->lastInsertId() : null;
    }



    private function writeLogContents ($contents)
    {
        $filepath = $this->errorFilepath;
        $contents = serialize($contents);
        $status = file_put_contents($filepath, $contents);
        return $status === false ? false : true;
    }



    private function addLog ($details)
    {
        if (!empty($_SESSION['user'])) {
            $userUsername = $_SESSION['user']['username'];
            $userName = $_SESSION['user']['user'];
            $user = $userName.' ('.$userUsername.')';
        } else {
            $user = 'No user is logged during the occurence of the query.';
        }
        $additionalContent = array(
                'datetime' => date('Y-m-d H:i:s'),
                'user' => $user,
                'details' => $details
            );

        $contents = $this->getDatabaseLogContents();
        array_push($contents, $additionalContent);
        $status = $this->writeLogContents($contents);
        return $status;
    }



    protected function getDatabaseLogContents ()
    {
        $core = new SystemCore();
        $filepath = $this->errorFilepath;
        $contents = file_get_contents($filepath);
        if ($core->unserializeable($contents)) {
            $contents = unserialize($contents);
        } else {
            $contents = array();
        }
        return $contents;
    }



    protected function displayDatabaseLogContents ()
    {
        $core = new SystemCore();
        $contents = $this->getDatabaseLogContents();
        arsort($contents);
        if (!empty($contents) && is_array($contents)) {
            $totalCount = count($contents);
            $html = '<span class="typo-type-5">Query count: '.$totalCount.'</span>
            <table class="table"><thead><tr>
            <th>#</th>
            <th>Date and Time</th>
            <th>User</th>
            <th>Details</th>
            </tr></thead><tbody>';
            foreach ($contents as $content) {
                $datetime = $core->transformDate($content['datetime']);
                $html .= '<tr>
                <td>'.$totalCount.'</td>
                <td>'.$datetime.'</td>
                <td>'.$content['user'].'</td>
                <td>'.nl2br($content['details']).'</td>
                </tr>';
                
                $totalCount--;
            }
            $html .= '</tbody></table>';
        } else {
            $html = 'The log has no contents yet.';
        }
        echo $html;
    }



    protected function cleanDatabaseLog ()
    {
        $contents = array();
        $status = $this->writeLogContents($contents);
        return $status;
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
                $arrays = $this->getEnum($tableName, $fieldName);
                $selectOptions = array();
                if (!empty($arrays) && is_array($arrays)) {
                    foreach ($arrays as $array) {
                        $selectOptions[$array] = $array;
                    }
                    return $selectOptions;
                } else {
                    return $defaultArray;
                }
                break;

            case 'table':
                $fieldName = explode(', ', $fieldName);
                if (count($fieldName) !== 2) {
                    $this->addLog('Program Error: Invalid use of Method dbSelectOptions under the Class Database.'.PHP_EOL.'Please notify your System Administrators regarding this error.');
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
                $this->addLog('Program Error: Class Database, Method dbSelectOptions, is not used properly.'.PHP_EOL.'Unknown type of Select Options to generate.');
        }
    }

}
