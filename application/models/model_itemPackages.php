<?php

class model_itemPackages {
    
    private $db;

    public function __construct () {
        $this->db = new database();
    }

    public function readPackage ($packageId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_package WHERE package_id = ? LIMIT 1"
            ,'v'=>array(intval($packageId))));
        return count($rows) > 0 ? $rows[0] : null;
    }



    public function searchPackages ($keyword) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_package
                WHERE
                    package_name LIKE ?
                    OR package_serial_no LIKE ?"
            ,'v'=>array(
                "%$keyword%"
                ,"%$keyword%")));
        return count($rows) > 0 ? $rows : null;
    }

}
