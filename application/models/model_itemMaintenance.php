<?php

class model_itemMaintenance {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function createMaintenance ($datas) {
        $d = array_map('trim', $datas);
        $a = $this->db->statement(array(
            'q'=>"INSERT INTO imts_items_maintenance(
                    maintenance_item
                    ,maintenance_assigned_staff
                    ,maintenance_date_submitted
                    ,maintenance_date_cleared
                    ,maintenance_status
                    ,maintenance_detailed_report
                ) VALUES(?,?,?,?,?,?)"
            ,'v'=>array(
                intval($d['maintenance-item'])
                ,intval($d['maintenance-assigned-staff'])
                ,date('Y-m-d')
                ,'0000-00-00'
                ,intval($d['maintenance-status'])
                ,$d['maintenance-detailed-report'])));
        if ($a) {
            $d['maintenance-id'] = $this->db->lastInsertId();
            return $d;
        } else
            return null;
    }



    public function readMaintenance ($maintenanceId) {
        $o = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_maintenance AS im
                LEFT JOIN imts_items AS it ON im.maintenance_item = it.item_id
                LEFT JOIN imts_persons AS ip ON im.maintenance_assigned_staff = ip.person_id
                WHERE im.maintenance_id = ?
                LIMIT 1"
            ,'v'=>array(
                intval($maintenanceId))));
        return count($o) > 0 ? $o[0] : null;
    }



    public function readMaintenances ($itemId) {
        $o = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_maintenance AS im
                LEFT JOIN imts_items AS it ON im.maintenance_item = it.item_id
                LEFT JOIN imts_persons AS ip ON im.maintenance_assigned_staff = ip.person_id
                WHERE im.maintenance_item = ?
                ORDER BY im.maintenance_date_submitted DESC"
            ,'v'=>array(
                intval($itemId))));
        return count($o) > 0 ? $o : null;
    }



    public function readProgresses ($maintenanceId) {
        $o = $this->db->statement(array(
            'q' => "SELECT * FROM imts_items_maintenance_progress
                WHERE progress_maintenance = ?"
            ,'v' => array(
                intval($maintenanceId))));
        return count($o) > 0 ? $o : null;
    }



    public function updateMaintenance ($datas) {
        $d = array_map('trim', $datas);
        $a = $this->db->statement(array(
            'q'=>"UPDATE imts_items_maintenance
                SET
                    maintenance_item = ?
                    ,maintenance_assigned_staff = ?
                    ,maintenance_status = ?
                    ,maintenance_detailed_report = ?
                WHERE maintenance_id = ?"
            ,'v'=>array(
                intval($d['maintenance-item'])
                ,intval($d['maintenance-assigned-staff'])
                ,intval($d['maintenance-status'])
                ,$d['maintenance-detailed-report']
                ,intval($d['maintenance-id']))));
        return $a ? $d : null;
    }



    public function searchMaintenances ($keyword) {
        $a = $this->db->statement(array(
            'q' => "SELECT * FROM imts_items_maintenance AS im
                LEFT JOIN imts_items AS it ON im.maintenance_item = it.item_id
                LEFT JOIN imts_persons AS ip ON im.maintenance_assigned_staff = ip.person_id
                WHERE
                    ip.person_lastname LIKE ?
                    OR ip.person_firstname LIKE ?
                    OR ip.person_middlename LIKE ?
                    OR ip.person_suffix LIKE ?
                    OR it.item_name LIKE ?
                    OR it.item_serial_no LIKE ?
                    OR it.item_model_no LIKE ?
                    AND it.item_archive_state = 0
                ORDER BY
                    im.maintenance_submitted_date ASC
                    ,ip.person_lastname ASC
                    ,ip.person_middlename ASC
                    ,ip.person_firstname ASC
                    ,ip.person_suffix ASC
                    ,it.item_name ASC
                    ,it.item_serial_no ASC
                    ,it.item_model_no ASC"
            ,'v' => array(
                "%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%")));
        return count($a) > 0 ? $a : null;
    }



    public function searchItems ($keyword) {
        $a = $this->db->statement(array(
            'q' => "SELECT * FROM imts_items
                WHERE
                    item_name LIKE ?
                    OR item_serial_no LIKE ?
                    OR item_model_no LIKE ?
                    AND item_archive_state = 0
                ORDER BY
                    item_name ASC
                    ,item_serial_no ASC
                    ,item_model_no ASC"
            ,'v' => array(
                "%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%")));
        return count($a) > 0 ? $a : null;
    }



    public function searchStaffs ($keyword) {
        $a = $this->db->statement(array(
            'q' => "SELECT * FROM imts_persons
                WHERE
                    person_lastname LIKE ?
                    OR person_middlename LIKE ?
                    OR person_firstname LIKE ?
                    OR person_suffix LIKE ?"
            ,'v' => array(
                "%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%")));
        return count($a) > 0 ? $a : null;
    }

}
