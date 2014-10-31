<?php

class ModelAccounts extends Accounts
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {
        
    }



    protected function validateUser ($username)
    {
        $query = "SELECT * FROM admin_accounts AS acc
            LEFT JOIN system_persons AS per ON
                acc.account_owner = per.person_id
            WHERE acc.account_username = ?
            LIMIT 1";
        $values = array($username);
        $results = $this->statement($query, $values);
        return $results;
    }



    protected function validateEmployment ($accountOwner)
    {
        $query = "SELECT * FROM hr_employees AS emp
            LEFT JOIN hr_departments AS dept ON
                emp.employee_department = dept.department_id
            LEFT JOIN hr_jobs AS job ON
                emp.employee_job = job.employee_job_id
            WHERE
                emp.employee_person = ? AND
                (
                    emp.employee_resignation_date > ? OR
                    emp.employee_resignation_date = '0000-00-00'
                    )";
        $values = array(
                intval($accountOwner),
                date('Y-m-d')
            );
        $results = $this->statement($query, $values);
        return $results;
    }

}
