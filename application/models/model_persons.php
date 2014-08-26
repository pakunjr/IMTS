<?php

class model_persons {

    private $db;

    public function __construct () {
        $this->db = new database();
    }
    


    public function createPerson () {

    }



    public function readPerson ($personId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_persons WHERE person_id = ? LIMIT 1"
            ,'v'=>array(intval($personId))));
        return count($rows) > 0 ? $rows[0] : null;
    }



    public function readPersonHeadDepartments ($personId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_departments WHERE department_head = ?"
            ,'v'=>array(intval($personId))));
        return count($rows) > 0 ? $rows : null;
    }



    public function isEmployee ($personId) {
        $currentDate = date('Y-m-d');
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_persons_employment
                WHERE
                    employee_person = ?
                    AND (employee_resignation_date = '0000-00-00'
                        OR employee_resignation_date > '$currentDate')"
            ,'v'=>array(intval($personId))));
        return count($rows) > 0 ? true : false;
    }



    public function isDepartmentHead ($personId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_departments WHERE department_head = ?"
            ,'v'=>array(intval($personId))));
        return count($rows) > 0 ? true : false;
    }

}
