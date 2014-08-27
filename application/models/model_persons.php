<?php

class model_persons {

    private $db;

    public function __construct () {
        $this->db = new database();
    }
    


    public function createPerson ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"INSERT INTO imts_persons(
                    person_firstname
                    ,person_middlename
                    ,person_lastname
                    ,person_suffix
                    ,person_gender
                    ,person_birthdate
                    ,person_address_a
                    ,person_address_b
                    ,person_contact_a
                    ,person_contact_b
                    ,person_email
                ) VALUES(?,?,?,?,?,?,?,?,?,?,?)"
            ,'v'=>array(
                $d['person-firstname']
                ,$d['person-middlename']
                ,$d['person-lastname']
                ,$d['person-suffix']
                ,$d['person-gender']
                ,$d['person-birthdate']
                ,$d['person-address-a']
                ,$d['person-address-b']
                ,$d['person-contact-a']
                ,$d['person-contact-b']
                ,$d['person-email'])));
        if ($res) {
            $d['person-id'] = $this->db->lastInsertId();
            return $d;
        } else return null;
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



    public function updatePerson ($datas) {
        $d = $datas;
        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_persons
                SET
                    person_firstname = ?
                    ,person_middlename = ?
                    ,person_lastname = ?
                    ,person_suffix = ?
                    ,person_gender = ?
                    ,person_birthdate = ?
                    ,person_address_a = ?
                    ,person_address_b = ?
                    ,person_contact_a = ?
                    ,person_contact_b = ?
                    ,person_email = ?
                WHERE person_id = ?"
            ,'v'=>array(
                    $d['person-firstname']
                    ,$d['person-middlename']
                    ,$d['person-lastname']
                    ,$d['person-suffix']
                    ,$d['person-gender']
                    ,$d['person-birthdate']
                    ,$d['person-address-a']
                    ,$d['person-address-b']
                    ,$d['person-contact-a']
                    ,$d['person-contact-b']
                    ,$d['person-email']
                    ,intval($d['person-id']))));
        return $res ? $d : null;
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
