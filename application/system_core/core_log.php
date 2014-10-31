<?php

class Log extends Database
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    public function createLog ($details, $type="Notice")
    {
        $details = preg_replace('/(<br \/>|<br\/>)/', PHP_EOL, $details);
        $loggedAccount = 0;
        if (!empty($_SESSION['user'])) {
            $loggedAccount = $_SESSION['user']['accountId'];
        }
        $query = "INSERT INTO system_logs(
                log_type,
                log_datetime,
                log_account,
                log_status,
                log_details
            ) VALUES(?,?,?,?,?)";
        $values = array(
                $type,
                date('Y-m-d H:i:s'),
                $loggedAccount,
                'Displayed',
                $details
            );
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function readLogs ($logStatus='Displayed')
    {
        $query = "SELECT * FROM system_logs AS log
            LEFT JOIN admin_accounts AS acc ON
                log.log_account = acc.account_id
            LEFT JOIN system_persons AS per ON
                acc.account_owner = per.person_id
            WHERE log.log_status = ?
            ORDER BY
                log.log_type ASC,
                log.log_type = 'Emergency',
                log.log_type = 'Critical',
                log.log_type = 'Alert',
                log.log_datetime DESC";
        $values = array($logStatus);
        $results = $this->statement($query, $values);
        return $results;
    }



    protected function archiveLogs ()
    {
        $query = "UPDATE system_logs
            SET log_status = ?
            WHERE log_status = ?";
        $values = array(
                'Archived',
                'Displayed'
            );
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function displayLog ()
    {
        
    }



    protected function searchLog ($keyword)
    {
        
    }

}
