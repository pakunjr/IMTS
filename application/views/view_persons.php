<?php

class view_persons {

    public function renderForm ($datas) {

    }



    public function renderPersonInformations ($personDatas) {
        if ($personDatas == null) return 'Error: This person do not exists in our system.';

        $pd = $personDatas;

        $fx = new myFunctions();
        $c_owners = new controller_owners();

        $personName = '<h3>'.$pd['person_lastname'].', '.$pd['person_firstname'].' '.$pd['person_middlename'].' '.$pd['person_suffix'].'</h3>';
        $ownedItems = $c_owners->displayOwnedItems('Person', $pd['person_id'], false);

        if ($pd['person_head_departments'] != null) {
            $departmentHeadOf = '';
            foreach ($pd['person_head_departments'] as $pdDept) {
                $departmentHeadOf .= '<a href="'.URL_BASE.'departments/read_department/'.$pdDept['department_id'].'/"><input type="button" value="'.$pdDept['department_name'].' ('.$pdDept['department_name_short'].')" /></a>';
            }
        } else $departmentHeadOf = 'None';

        $personGender = $pd['person_gender'] == 'm' ? 'Male' : 'Female';
        $personIsEmployee = $pd['person_is_employee'] ? 'Yes' : 'No';
        $output = $personName.'<hr />'
            .'<div class="accordion-title">Person Information</div><div class="accordion-content accordion-content-default">'
            .'<table>'
            .'<tr>'
                .'<th>Firstname</th>'
                .'<td>'.$pd['person_firstname'].'</td>'
                .'<th>Birthdate</th>'
                .'<td>'.$fx->dateToWords($pd['person_birthdate']).'</td>'
                .'<th rowspan="2">Address</th>'
                .'<td>'.$pd['person_address_a'].'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Middlename</th>'
                .'<td>'.$pd['person_middlename'].'</td>'
                .'<th>Is Employee?</th>'
                .'<td>'.$personIsEmployee.'</td>'
                .'<td>'.$pd['person_address_b'].'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Lastname</th>'
                .'<td>'.$pd['person_lastname'].'</td>'
                .'<th rowspan="3">Contact</th>'
                .'<td>'.$pd['person_contact_a'].'</td>'
                .'<th rowspan="3">Head Of</th>'
                .'<td rowspan="3">'.$departmentHeadOf.'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Suffix</th>'
                .'<td>'.$pd['person_suffix'].'</td>'
                .'<td>'.$pd['person_contact_b'].'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Gender</th>'
                .'<td>'.$personGender.'</td>'
                .'<td>'.$pd['person_email'].'</td>'
            .'</tr>'
            .'<tr>'
            .'</tr>'
            .'</table>'
            .'</div>'

            .'<div class="accordion-title">Ownership History</div><div class="accordion-content">'.$ownedItems.'</div>'

            .'<hr /><a href="'.URL_BASE.'persons/update_person/'.$pd['person_id'].'/"><input class="btn-green" type="button" value="Update" /></a>';
        return $output;
    }



    public function renderPersonName ($person) {
        $p = $person;
        if ($p != null) return $p['person_lastname'].', '.$p['person_firstname'].' '.$p['person_middlename'].' '.$p['person_suffix'];
        else return 'Unknown Person';
    }

}
