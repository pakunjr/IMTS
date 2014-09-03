<?php

class database {

    private $connection;

    private $host;
    private $username;
    private $password;
    private $database;
    private $port;
    private $socket;

    public function __construct ($config=null) {
        if ($config == null) {
            $this->host = DATABASE_HOST;
            $this->username = DATABASE_USERNAME;
            $this->password = DATABASE_PASSWORD;
            $this->database = DATABASE_NAME;
            $this->port = DATABASE_PORT;
            $this->socket = DATABASE_SOCKET;
        }
    }



    public function connect () {
        $host = $this->host;
        $database = $this->database;
        $username = $this->username;
        $password = $this->password;

        $connection = new PDO(
            'mysql:host='.$host.';dbname='.$database
            ,$username
            ,$password
            ,array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH));
        $this->connection = $connection;
    }



    public function statement ($options=array()) {
        $c_errors = new controller_errors();

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
            $this->c_err->logError($e->getMessage().PHP_EOL
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
                    $c_errors->logError('Failed to bind parameter.'.PHP_EOL
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
                $c_errors->logError('Unknown type of SQL statement.');
            }
        } catch ( PDOException $e ) {
            $c_errors->logError('Failed in executing the statement.'.PHP_EOL.PHP_EOL
                .'SQL Query: '.$q.PHP_EOL.PHP_EOL
                .'Reason'. $e->getMessage);
        }
    }



    public function disconnect () {
        $this->connection->close();
    }



    public function lastInsertId () {
        return $this->connection->lastInsertId();
    }

}
