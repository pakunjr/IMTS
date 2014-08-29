<?php

class model_employees {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function createEmployment ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"INSERT INTO imts_persons_employment(
                    employee_no
                    ,employee_person
                    ,employee_status
                    ,employee_job
                    ,employee_department
                    ,employee_employment_date
                    ,employee_resignation_date
                ) VALUES(?,?,?,?,?,?,?)"
            ,'v'=>array(
                $d['employee-no']
                ,intval($d['employee-person'])
                ,intval($d['employee-status'])
                ,intval($d['employee-job'])
                ,intval($d['employee-department'])
                ,$d['employee-employment-date']
                ,$d['employee-resignation-date'])));
        if ($res) {
            $d['employee-id'] = $this->db->lastInsertId();
            return $d;
        } else return null;
    }



    public function createJob ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"INSERT INTO imts_persons_employment_jobs(
                    employee_job_label
                    ,employee_job_description
                ) VALUES(?,?)"
            ,'v'=>array(
                $d['employee-job-label']
                ,$d['employee-job-description'])));
        if ($res) {
            $d['employee-job-id'] = $this->db->lastInsertId();
            return $d;
        } else return null;
    }



    public function readPersonEmployment ($personId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons_employment_jobs AS job
                    ON emp.employee_job = job.employee_job_id
                LEFT JOIN imts_persons_employment_status AS sta
                    ON emp.employee_status = sta.employee_status_id
                WHERE emp.employee_person = ?
                ORDER BY
                    FIELD(emp.employee_resignation_date, '0000-00-00') DESC
                    ,emp.employee_resignation_date DESC"
            ,'v'=>array(
                intval($personId))));
        return count($rows) > 0 ? $rows : null;
    }



    public function readEmployee ($employeeId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_jobs AS emp_job
                    ON emp.employee_job = emp_job.employee_job_id
                WHERE employee_id = ? LIMIT 1"
            ,'v'=>array(
                intval($employeeId))));
        return count($rows) > 0 ? $rows[0] : null;
    }



    public function readJob ($jobId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_persons_employment_jobs WHERE employee_job_id = ? LIMIT 1"
            ,'v'=>array(intval($jobId))));
        return count($rows) > 0 ? $rows[0] : null;
    }



    public function updateEmployment ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_persons_employment
                SET
                    employee_no = ?
                    ,employee_status = ?
                    ,employee_job = ?
                    ,employee_department = ?
                    ,employee_employment_date = ?
                    ,employee_resignation_date = ?
                WHERE
                    employee_id = ?
                    AND employee_person = ?"
            ,'v'=>array(
                $d['employee-no']
                ,intval($d['employee-status'])
                ,intval($d['employee-job'])
                ,intval($d['employee-department'])
                ,$d['employee-employment-date']
                ,$d['employee-resignation-date']
                ,intval($d['employee-id'])
                ,intval($d['employee-person']))));
        return $res ? $d : null;
    }



    public function updateJob ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_persons_employment_jobs
                SET
                    employee_job_label = ?
                    ,employee_job_description = ?
                WHERE employee_job_id = ?"
            ,'v'=>array(
                $d['employee-job-label']
                ,$d['employee-job-description']
                ,intval($d['employee-job-id']))));
        return $res ? $d : null;
    }



    public function deleteJob ($jobId) {
        $res = $this->db->statement(array(
            'q'=>"DELETE FROM imts_persons_employment_jobs WHERE job_id = ?"
            ,'v'=>array(intval($jobId))));
        return $res;
    }



    public function endEmployment ($employeeId) {
        $currentDate = date('Y-m-d');
        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_persons_employment
                SET employee_resignation_date = '$currentDate'
                WHERE employee_id = ?"
            ,'v'=>array(intval($employeeId))));
        return $res;
    }



    public function searchEmployees ($keyword) {
        $currentDate = date('Y-m-d');
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_persons_employment AS emp
                LEFT JOIN imts_persons AS per
                    ON emp.employee_person = per.person_id
                LEFT JOIN imts_persons_employment_status AS emp_stat
                    ON emp.employee_status = emp_stat.employee_status_id
                LEFT JOIN imts_persons_employment_jobs AS emp_job
                    ON emp.employee_job = emp_job.employee_job_id
                WHERE
                    (emp.employee_resignation_date > '$currentDate'
                    OR emp.employee_resignation_date = '0000-00-00')
                    AND (per.person_firstname LIKE ?
                    OR per.person_middlename LIKE ?
                    OR per.person_lastname LIKE ?
                    OR emp_job.employee_job_label LIKE ?)"
            ,'v'=>array(
                "%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%"
                ,"%$keyword%")));
        return count($rows) > 0 ? $rows : null;
    }



    public function searchJobs ($keyword) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_persons_employment_jobs WHERE employee_job_label LIKE ?"
            ,'v'=>array(
                "%$keyword%")));
        return count($rows) ? $rows : null;
    }

}
