<?php

class model_employeeStatus {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function readStatuses () {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_persons_employment_status"));
        return count($rows) > 0 ? $rows : null;
    }

}
