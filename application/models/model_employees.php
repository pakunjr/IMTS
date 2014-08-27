<?php

class model_employees {

    private $db;

    public function __construct () {
        $this->db = new database();
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

}
