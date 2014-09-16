<?php

class model_itemPackages {
    
    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function createPackage ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"INSERT INTO imts_items_package(
                    package_name
                    ,package_serial_no
                    ,package_description
                    ,package_date_of_purchase
                ) VALUES(?,?,?,?)"
            ,'v'=>array(
                    $d['package-name']
                    ,$d['package-serial-no']
                    ,$d['package-description']
                    ,$d['package-date-of-purchase'])));
        if ($res) {
            $d['package-id'] = $this->db->lastInsertId();
            return $d;
        } else return null;
    }



    public function readPackage ($packageId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_package WHERE package_id = ? LIMIT 1"
            ,'v'=>array(intval($packageId))));
        return count($rows) > 0 ? $rows[0] : null;
    }



    public function readPackageItems ($packageId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items WHERE item_package = ? ORDER BY item_archive_state ASC"
            ,'v'=>array(intval($packageId))));
        return count($rows) > 0 ? $rows : null;
    }



    public function updatePackage ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_items_package
                SET
                    package_name = ?
                    ,package_serial_no = ?
                    ,package_description = ?
                    ,package_date_of_purchase = ?
                WHERE package_id = ?"
            ,'v'=>array(
                    $d['package-name']
                    ,$d['package-serial-no']
                    ,$d['package-description']
                    ,$d['package-date-of-purchase']
                    ,intval($d['package-id']))));
        return $res ? $d : null;
    }



    public function searchPackages ($keyword) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_package
                WHERE
                    package_name LIKE ?
                    OR package_serial_no LIKE ?
                ORDER BY package_name ASC"
            ,'v'=>array(
                "%$keyword%"
                ,"%$keyword%")));
        return count($rows) > 0 ? $rows : null;
    }

}
