<?php

class model_errors {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function readErrors () {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_logs_errors AS err
                LEFT JOIN imts_accounts AS acc ON err.error_logged_account = acc.account_id
                LEFT JOIN imts_persons AS per ON acc.account_owner = per.person_id
                WHERE err.error_archived = 0
                ORDER BY err.error_id DESC"));
        return count($rows) > 0 ? $rows : null;
    }



    public function logError ($details) {
        $currentLoggedAccount = isset($_SESSION['user'])
            ? $_SESSION['user']['accountId']
            : '';
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $res = $this->db->statement(array(
            'q'=>"INSERT INTO imts_logs_errors(
                    error_logged_account
                    ,error_description
                    ,error_date
                    ,error_time
                    ,error_archived
                ) VALUES(?,?,?,?,?)"
            ,'v'=>array(
                intval($currentLoggedAccount)
                ,$details
                ,$currentDate
                ,$currentTime
                ,intval(0))));
        return $res;
    }



    public function archiveLogs () {
        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_logs_errors SET error_archived = 1"));
        return $res;
    }

}
