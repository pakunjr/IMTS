<?php

class model_itemMaintenance {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function createItemMaintenance ($datas) {
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



    public function readItemMaintenance ($maintenanceId) {
        $o = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_maintenance
                WHERE maintenance_id = ?
                LIMIT 1"
            ,'v'=>array(
                intval($maintenanceId))));
        return count($o) > 0 ? $o[0] : null;
    }

}
