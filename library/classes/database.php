<?php

class database {

    private $connection;

    private $host;
    private $username;
    private $password;
    private $database;
    private $port;
    private $socket;

    private $errorFile;

    public function __construct ($config=null) {
        if ($config == null) {
            $this->host = DATABASE_HOST;
            $this->username = DATABASE_USERNAME;
            $this->password = DATABASE_PASSWORD;
            $this->database = DATABASE_NAME;
            $this->port = DATABASE_PORT;
            $this->socket = DATABASE_SOCKET;
        }

        $this->errorFile = DIR_LIBRARY.DS.'logs'.DS.'db_errors.php';
        $this->errorFile = file_exists($this->errorFile) ? $this->errorFile : null;
    }



    public function connect () {
        $host = $this->host;
        $database = $this->database;
        $username = $this->username;
        $password = $this->password;

        try {
            $connection = new PDO(
                'mysql:host='.$host.';dbname='.$database
                ,$username
                ,$password
                ,array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH));
            $this->connection = $connection;
        } catch (PDOException $e) {
            $this->logDatabaseError('Cannot connect to the database.'.PHP_EOL.'PDO Connection failed.');
        }
    }



    public function statement ($options=array()) {
        $this->connect();
        $connection = $this->connection;

        $q = isset($options['q']) ? $options['q'] : '';
        $v = isset($options['v']) && is_array($options['v'])
            ? $options['v']
            : array();

        //Prepare the statement
        try {
            $stmt = $connection->prepare($q);
            if ( !$stmt )
                throw new PDOException('PDOException: Failed to prepare the query.');
        } catch ( PDOException $e ) {
            $this->logDatabaseError($e->getMessage().PHP_EOL.PHP_EOL
                .'SQL Query: '.$q);
        }

        //Bind the parameters
        if ( is_array($v) ) {
            $ph = 0;
            foreach ( $v as $value ) {
                $type = gettype($value) == 'integer'
                    ? PDO::PARAM_INT
                    : PDO::PARAM_STR;
                $ph++;
                $status = $stmt->bindValue($ph, $value, $type)
                    ? true : false;

                if ( !$status ) {
                    $this->logDatabaseError('Failed to bind parameter.'.PHP_EOL
                        .'Placeholder: '.$ph.PHP_EOL
                        .'Value: '.$value);
                }
            }
        }

        //Execute the statement and return necessary output
        try {
            if ( strpos($q, 'SELECT') !== false ) {
                $array = array();
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ( $row = $stmt->fetch() ) {
                    array_push($array, $row);
                }

                return $array;
            } else if ( strpos($q, 'INSERT') !== false
                    || strpos($q, 'UPDATE') !== false
                    || strpos($q, 'DELETE') !== false ) {
                return $stmt->execute();
            } else {
                $this->logDatabaseError('Unknown type of SQL statement.');
            }
        } catch ( PDOException $e ) {
            $this->logDatabaseError('Failed in executing the statement.'.PHP_EOL.PHP_EOL
                .'SQL Query: '.$q.PHP_EOL.PHP_EOL
                .'Reason: '.$e->getMessage());
        }
    }



    public function disconnect () {
        $this->connection->close();
    }



    public function lastInsertId () {
        return $this->connection->lastInsertId();
    }



    public function displayDatabaseErrors () {
        $file = $this->errorFile;
        if ($file == null) {
            echo 'Fatal Error: Your log file for database errors is missing.<br />Please create your log file `db_errors.php` on the directory root > library > logs > db_errors.php';
            exit();
        }

        $fx = new myFunctions();

        $content = file_get_contents($file);
        $content = unserialize($content);

        if (!is_array($content) || count($content) < 1) {
            echo 'There are no logged database error/s yet.<hr />'
                .'<a href="'.URL_BASE.'admin/log/database_errors/"><input type="button" value="Refresh" /></a>';
            return;
        }

        krsort($content);

        $output = '<table><tr>'
            .'<th>No.</th>'
            .'<th>Date and Time</th>'
            .'<th>Logged User</th>'
            .'<th>Details</th>'
            .'</tr>';
        foreach ($content as $i => $c) {
            $output .= '<tr>'
                .'<td>'.$i.'</td>'
                .'<td>'.$fx->dateToWords($c['date']).' @ '.$c['time'].'</td>'
                .'<td>'.$c['user'].'</td>'
                .'<td>'.nl2br($c['details']).'</td>'
                .'</tr>';
        }
        $output .= '</table><hr />'
            .'<a href="'.URL_BASE.'admin/log/database_errors/"><input type="button" value="Refresh" /></a>'
            .'<a href="'.URL_BASE.'admin/log/database_errors/clean/"><input class="btn-red" type="button" value="Clean Database Errors Log" /></a>';
        echo $output;
    }



    public function logDatabaseError ($details) {
        $file = $this->errorFile;
        if ($file == null) {
            echo 'Fatal Error: Database encountered an error and your log file for these type of errors is missing.<br />Please create your log file `db_errors.php` on the directory root > library > logs > db_errors.php';
            exit();
        }

        $content = file_get_contents($file);
        $content = unserialize($content);
        $content = !is_array($content) ? array() : $content;

        $error = array(
            'date'=>date('Y-m-d')
            ,'time'=>date('H:i:s')
            ,'user'=>isset($_SESSION['user']) ? $_SESSION['user']['username'].' -- '.$_SESSION['user']['name'] : 'No logged account.'
            ,'details'=>$details);

        $content[count($content) + 1] = $error;
        $content = serialize($content);
        $logSuccess = file_put_contents($file, $content);

        if (!$logSuccess) {
            echo 'Fatal Error: Failed to log database error due to unknown reason/s.';
            exit();
        }
    }



    public function cleanDatabaseErrors () {
        $file = $this->errorFile;
        if ($file == null) {
            echo 'Fatal Error: Your log file for database errors is missing.<br />Please create your log file `db_errors.php` on the directory root > library > logs > db_errors.php';
            exit();
        }

        file_put_contents($file, '');
        $contents = file_get_contents($file);

        if (strlen(trim($contents)) > 0) {
            echo 'Action Error: Failed to clean database errors due to unknown reason/s.<br /><a href="'.URL_BASE.'admin/log/database_errors/">Click here to go back.</a>';
            exit();
        }
    }

}
