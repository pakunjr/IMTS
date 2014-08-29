<?php

class model_departments {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function createDepartment ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"INSERT INTO imts_departments(
                    department_head
                    ,department_description
                    ,department_name
                    ,department_name_short
                ) VALUES(?,?,?,?)"
            ,'v'=>array(
                intval($d['department-head'])
                ,$d['department-description']
                ,$d['department-name']
                ,$d['department-name-short'])));
        if ($res) {
            $d['department-id'] = $this->db->lastInsertId();
            return $d;
        } else return null;
    }



    public function readDepartment ($departmentId) {
        $department = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_departments WHERE department_id = ? LIMIT 1"
            ,'v'=>array(intval($departmentId))));
        return count($department) > 0 ? $department[0] : null;
    }



    public function readDepartmentMembers ($departmentId) {
        $currentDate = date('Y-m-d');
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS job
                    ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta
                    ON emp.employee_status = sta.employee_status_id
                WHERE emp.employee_department = ?
                    AND (emp.employee_resignation_date > '$currentDate'
                        OR emp.employee_resignation_date = '0000-00-00')"
            ,'v'=>array(
                intval($departmentId))));
        return count($rows) > 0 ? $rows : null;
    }



    public function updateDepartment ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_departments
                SET
                    department_head = ?
                    ,department_description = ?
                    ,department_name = ?
                    ,department_name_short = ?
                WHERE department_id = ?"
            ,'v'=>array(
                intval($d['department-head'])
                ,$d['department-description']
                ,$d['department-name']
                ,$d['department-name-short']
                ,intval($d['department-id']))));
        return $res ? $d : null;
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
