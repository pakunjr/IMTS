<?php

class view_persons {

    public function renderForm ($datas) {
        $d = $datas;

        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $personName = $d != null
            ? '<h3>'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'</h3>'
            : '<h3>New Person</h3>';

        $actionLink = $d != null
            ? URL_BASE.'persons/update_person/save/'
            : URL_BASE.'persons/create_person/save/';

        $employmentFieldset = $d != null
            ? ''
            : $f->openFieldset(array('legend'=>'Employment'))
            .'<span class="column">If this person is an employee, you can add the details of employment after you have saved the basic informations of the person.</span>'
            .$f->closeFieldset();
        $cancelButton = $d != null
            ? '<a href="'.URL_BASE.'persons/read_person/'.$d['person_id'].'/">'.$f->button(array('value'=>'Cancel', 'auto_line_break'=>false)).'</a>'
            : '';
        $addEmploymentButton = $d != null
            ? '<a href="'.URL_BASE.'employees/create_employment/'.$d['person_id'].'/">'.$f->button(array('class'=>'btn-green', 'value'=>'Add Employment')).'</a>'
            : '';
        $addEmploymentButton = in_array($accessLevel, array('Administrator', 'Admin', 'Supervisor')) ? $addEmploymentButton : '';

        $output = $personName.$f->openForm(array('id'=>'', 'class'=>'main-form', 'method'=>'post', 'action'=>$actionLink, 'enctype'=>'multipart/form-data'))
            .$f->hidden(array('id'=>'person-id', 'value'=>$d != null ? $d['person_id'] : '0'))

            .$f->openFieldset(array('class'=>'column', 'legend'=>'Biodata'))
            .'<span class="column">'
            .$f->text(array('id'=>'person-firstname', 'label'=>'Firstname', 'value'=>$d != null ? $d['person_firstname'] : ''))
            .$f->text(array('id'=>'person-middlename', 'label'=>'Middlename', 'value'=>$d != null ? $d['person_middlename'] : ''))
            .$f->text(array('id'=>'person-lastname', 'label'=>'Lastname', 'value'=>$d != null ? $d['person_lastname'] : ''))
            .$f->text(array('id'=>'person-suffix', 'label'=>'Suffix', 'value'=>$d != null ? $d['person_suffix'] : ''))
            .$f->text(array('id'=>'person-birthdate', 'class'=>'datepicker', 'label'=>'Birthdate', 'value'=>$d != null ? $d['person_birthdate'] : '0000-00-00'))
            .'</span>'

            .'<span class="column">'
            .$f->select(array('id'=>'person-gender', 'label'=>'Gender', 'select_options'=>array(
                'Female'=>'f', 'Male'=>'m'), 'default_option'=>$d != null ? $d['person_gender'] : 'm'))
            .'</span>'
            .$f->closeFieldset()

            .$f->openFieldset(array('class'=>'column', 'legend'=>'Contact'))
            .'<span class="column">'
            .$f->text(array('id'=>'person-address-a', 'label'=>'Address A', 'value'=>$d != null ? $d['person_address_a'] : ''))
            .$f->text(array('id'=>'person-address-b', 'label'=>'Address B', 'value'=>$d != null ? $d['person_address_b'] : ''))
            .$f->text(array('id'=>'person-contact-a', 'label'=>'Contact #1', 'value'=>$d != null ? $d['person_contact_a'] : ''))
            .$f->text(array('id'=>'person-contact-b', 'label'=>'Contact #2', 'value'=>$d != null ? $d['person_contact_b'] : ''))
            .$f->text(array('id'=>'person-email', 'label'=>'Email', 'value'=>$d != null ? $d['person_email'] : ''))
            .'</span>'
            .$f->closeFieldset()

            .$employmentFieldset

            .'<div>'
            .$f->submit(array('value'=>$d != null ? 'Update Person' : 'Save Person', 'auto_line_break'=>false))
            .$cancelButton
            .$addEmploymentButton
            .'</div>'
            .$f->closeForm();
        return $output;
    }



    public function renderSearchForm ($keyword) {
        $f = new form(array('auto_line_break'=>false, 'auto_label'=>true));
        $output = $f->openForm(array('id'=>'', 'method'=>'post', 'action'=>URL_BASE.'persons/search_person/', 'enctype'=>'multipart/form-data')).$f->text(array('id'=>'search-keyword', 'label'=>'Search', 'value'=>$keyword)).$f->submit(array('value'=>'Search')).$f->closeForm().'<hr />';
        return $output;
    }



    public function renderSearchResults ($datas) {
        if ($datas == null) return 'There are no person/s that matched your keyword.<hr /><a href="'.URL_BASE.'persons/create_person/" target="_blank"><input class="btn-green" type="button" value="Add a Person" /></a>';

        $fx = new myFunctions();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $output = '<table><tr>'
            .'<th>Lastname</th>'
            .'<th>Firstname</th>'
            .'<th>Middlename</th>'
            .'<th>Suffix</th>'
            .'<th>Gender</th>'
            .'<th>Birthdate</th>'
            .'<th colspan="2">Address</th>'
            .'<th colspan="3">Contact</th>';
        if (isset($_POST['search-keyword'])) {
            $output .= !in_array($accessLevel, array('Viewer'))
                ? '<th>Actions</th>' : '';
        }
        $output .= '</tr>';
        foreach ($datas as $d) {
            $personGender = $d['person_gender'] == 'm' ? 'Male' : 'Female';

            $output .= '<tr class="data" '
                .'data-id="'.$d['person_id'].'" '
                .'data-label="'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'" '
                .'data-url="'.URL_BASE.'persons/read_person/'.$d['person_id'].'/">'
                .'<td>'.$d['person_lastname'].'</td>'
                .'<td>'.$d['person_firstname'].'</td>'
                .'<td>'.$d['person_middlename'].'</td>'
                .'<td>'.$d['person_suffix'].'</td>'
                .'<td>'.$personGender.'</td>'
                .'<td>'.$fx->dateToWords($d['person_birthdate']).'</td>'
                .'<td>'.$d['person_address_a'].'</td>'
                .'<td>'.$d['person_address_b'].'</td>'
                .'<td>'.$d['person_contact_a'].'</td>'
                .'<td>'.$d['person_contact_b'].'</td>'
                .'<td>'.$d['person_email'].'</td>';
            if (isset($_POST['search-keyword'])) {
                $output .= !in_array($accessLevel, array('Viewer'))
                    ? '<td><a href="'.URL_BASE.'persons/update_person/'.$d['person_id'].'/"><input class="btn-green" type="button" value="Update Person" /></a></td>'
                    : '';
            }
            $output .= '</tr>';
        }
        $output .= '</table>'
            .'<hr />';
        $output .= !in_array($accessLevel, array('Viewer'))
            ? '<a href="'.URL_BASE.'persons/create_person/" target="_blank"><input class="btn-green" type="button" value="Add a Person" /></a>'
            : '';
        return $output;
    }



    public function renderPersonInformations ($personDatas) {
        if ($personDatas == null) return 'Error: This person do not exists in our system.';

        $pd = $personDatas;

        $fx = new myFunctions();
        $c_owners = new controller_owners();
        $c_employees = new controller_employees();
        $c_accounts = new controller_accounts();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $personName = '<h3>'.$pd['person_lastname'].', '.$pd['person_firstname'].' '.$pd['person_middlename'].' '.$pd['person_suffix'].'</h3>';
        $ownedItems = $c_owners->displayOwnedItems('Person', $pd['person_id'], false);

        if ($pd['person_head_departments'] != null) {
            $departmentHeadOf = '';
            foreach ($pd['person_head_departments'] as $pdDept) {
                $departmentHeadOf .= '<a href="'.URL_BASE.'departments/read_department/'.$pdDept['department_id'].'/"><input type="button" value="'.$pdDept['department_name'].' ('.$pdDept['department_name_short'].')" /></a>';
            }
        } else $departmentHeadOf = 'None';

        $createAccountButton = in_array($accessLevel, array('Administrator', 'Admin'))
                ? '<a href="'.URL_BASE.'accounts/create_account/'.$pd['person_id'].'/"><input class="btn-green" type="button" value="Create an Account for this Person" /></a>'
                : '';

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
                .'<th>Head Of</th>'
                .'<td>'.$departmentHeadOf.'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Middlename</th>'
                .'<td>'.$pd['person_middlename'].'</td>'
                .'<th>Is Employee?</th>'
                .'<td>'.$personIsEmployee.'</td>'
                .'<th rowspan="4">Address</th>'
                .'<td rowspan="2">'.$pd['person_address_a'].'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Lastname</th>'
                .'<td>'.$pd['person_lastname'].'</td>'
                .'<th rowspan="3">Contact</th>'
                .'<td>'.$pd['person_contact_a'].'</td>'
            .'</tr>'
            .'<tr>'
                .'<th>Suffix</th>'
                .'<td>'.$pd['person_suffix'].'</td>'
                .'<td>'.$pd['person_contact_b'].'</td>'
                .'<td rowspan="2">'.$pd['person_address_b'].'</td>'
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

            .'<div class="accordion-title">Employment History</div><div class="accordion-content">'.$c_employees->displayEmploymentHistory($pd['person_id'], false).'</div>'

            .'<div class="accordion-title">Accounts on the System</div><div class="accordion-content">'.$c_accounts->displayPersonAccounts($pd['person_id'], false).'</div>'

            .'<hr />';
        $output .= !in_array($accessLevel, array('Viewer'))
            ? '<a href="'.URL_BASE.'persons/update_person/'.$pd['person_id'].'/"><input class="btn-green" type="button" value="Update Person" /></a>'
            : '';
        $output .= in_array($accessLevel, array('Administrator', 'Admin', 'Supervisor'))
            ? '<a href="'.URL_BASE.'employees/create_employment/'.$pd['person_id'].'/"><input class="btn-green" type="button" value="Add Employment" /></a>'
                .$createAccountButton
            : '';
        return $output;
    }



    public function renderPersonName ($person) {
        $p = $person;
        if ($p != null) return $p['person_lastname'].', '.$p['person_firstname'].' '.$p['person_middlename'].' '.$p['person_suffix'];
        else return 'None';
    }

}
