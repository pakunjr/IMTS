<?php

class model_departments {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function readDepartment ($departmentId) {
        $department = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_departments WHERE department_id = ? LIMIT 1"
            ,'v'=>array(intval($departmentId))));
        return count($department) > 0 ? $department[0] : null;
    }



    public function searchDepartments ($keyword) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_departments WHERE department_name LIKE ? OR department_name_short LIKE ?"
            ,'v'=>array(
                "%$keyword%"
                ,"%$keyword%")));
        return count($rows) > 0 ? $rows : null;
    }
    
}
