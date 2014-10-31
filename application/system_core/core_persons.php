<?php

class Persons extends Database
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    protected function createPerson ($datas)
    {

    }



    protected function readPerson ($personId)
    {
        $query = "SELECT * FROM system_persons
            WHERE person_id = ?
            LIMIT 1";
        $values = array(intval($personId));
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function updatePerson ($datas, $personId)
    {

    }



    protected function deletePerson ($personId)
    {
        $query = "DELETE FROM system_persons
            WHERE person_id = ?";
        $values = array(intval($personId));
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function searchPerson ($keyword)
    {
        $query = "SELECT * FROM system_persons
            WHERE
                person_firstname LIKE ? OR
                person_middlename LIKE ? OR
                person_lastname LIKE ? OR
                person_suffix LIKE ? OR
                person_gender LIKE ? OR
                person_email LIKE ? OR
                person_educational_degree LIKE ? OR
                person_educational_background LIKE ?";
        $values = array(
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%"
            );
        $results = $this->statement($query, $values);
        return $results;
    }



    protected function searchEmployee ($keyword)
    {
        $currentDate = date('Y-m-d');
        $query = "SELECT * FROM system_persons AS per
            LEFT JOIN hr_employees AS emp ON
                per.person_id = emp.employee_person
            WHERE
                (
                    emp.employee_resignation_date = '0000-00-00' OR
                    emp.employee_resignation_date > '$currentDate'
                    ) AND
                (
                    per.person_firstname LIKE ? OR
                    per.person_middlename LIKE ? OR
                    per.person_lastname LIKE ? OR
                    per.person_suffix LIKE ? OR
                    per.person_gender LIKE ? OR
                    per.person_email LIKE ? OR
                    per.person_educational_degree LIKE ? OR
                    per.person_educational_background LIKE ?
                    )";
        $values = array(
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%"
            );
        $results = $this->statement($query, $values);
        return $results;
    }



    protected function addEmployment ()
    {
        $query = "";
        $values = array();
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function readEmployments ($personId)
    {
        $currentDate = date('Y-m-d');
        $query = "SELECT * FROM hr_employees AS emp
            LEFT JOIN hr_jobs AS job ON
                emp.employee_job = job.employee_job_id
            LEFT JOIN hr_departments AS dept ON
                emp.employee_department = dept.department_id
            WHERE
                emp.employee_person = ? AND
                (
                    emp.employee_resignation_date = '0000-00-00' OR
                    emp.employee_resignation_date > '$currentDate'
                    )
            ORDER BY
                emp.employee_employment_date ASC,
                emp.employee_resignation_date ASC,
                emp.employee_resignation_date = '0000-00-00'";
        $values = array(intval($personId));
        $results = $this->statement($query, $values);
        return $results;
    }



    protected function endEmployment ($employmentId)
    {
        $query = "UPDATE hr_employees
            SET employee_resignation_date = ?
            WHERE employee_id = ?";
        $values = array(
                date('Y-m-d'),
                intval($employmentId)
            );
        $result = $this->statement($query, $values);
        return $result;
    }

}
