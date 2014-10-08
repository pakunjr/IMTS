<?php

class model_logs {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function createLog ($datas) {
        $accountId = isset($_SESSION['user'])
            ? $_SESSION['user']['accountId']
            : 0;

        $query = "INSERT INTO imts_logs(
                log_type
                ,log_level
                ,log_datetime
                ,log_account
                ,log_status
                ,log_details
            ) VALUES(?,?,?,?,?,?)";

        $values = array(
            $datas['log-type']
            ,$datas['log-level']
            ,date('Y-m-d H:i:s')
            ,$accountId
            ,'Displayed'
            ,$datas['log-details']);

        $logs = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return count($logs) > 0 ? $logs : null;
    }



    public function readLog ($logId) {
        $query = "SELECT * FROM imts_logs
            WHERE log_id = ?";

        $values = array(
            intval($logId));

        $logs = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return count($logs) > 0 ? $logs : null;
    }



    public function readLogs () {
        $query = "SELECT * FROM imts_logs
            WHERE log_status = 'Displayed'
            ORDER BY log_level ASC";

        $values = array();

        $logs = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return count($logs) > 0 ? $logs : null;
    }



    public function readArchivedLogs () {
        $query = "SELECT * FROM imts_logs
            WHERE log_status = 'Archived'";

        $values = array();

        $logs = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return count($logs) > 0 ? $logs : null;
    }



    public function deleteLog ($logId) {
        $query = "DELETE FROM imts_logs
            WHERE log_id = ?";

        $values = array(
            intval($logId));

        $status = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return $status;
    }

}
