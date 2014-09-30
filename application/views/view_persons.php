<?php

class view_persons {

    public function __construct () {

    }



    public function __destruct () {

    }



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

        $output = $personName
            .'<div class="hr-light"></div>'
            .$f->openForm(array('id'=>'', 'class'=>'main-form', 'method'=>'post', 'action'=>$actionLink, 'enctype'=>'multipart/form-data'))
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

            .$f->openFieldset(array('class'=>'column', 'legend'=>'Education'))
            .$f->text(array('id'=>'person-educational-degree', 'label'=>'Degree', 'value'=>$d != null ? $d['person_educational_degree'] : ''))
            .$f->textarea(array('id'=>'person-educational-background', 'label'=>'Background', 'value'=>$d != null ? $d['person_educational_background'] : ''))
            .$f->closeFieldset()

            .$employmentFieldset

            .'<div class="hr-light"></div>'
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
        $output = $f->openForm(array('id'=>'', 'method'=>'post', 'action'=>URL_BASE.'persons/search_person/', 'enctype'=>'multipart/form-data')).$f->text(array('id'=>'search-keyword', 'label'=>'Search', 'value'=>$keyword)).$f->submit(array('value'=>'Search')).$f->closeForm().'<div class="hr-light"></div>';
        return $output;
    }



    public function renderSearchResults ($datas) {
        if ($datas == null) {
            $output = 'There are no person/s that matched your keyword.<div class="hr-light"></div>';
            $output .= !in_array($accessLevel, array('Viewer'))
                ? '<a href="'.URL_BASE.'persons/create_person/" target="_blank"><input class="btn-green" type="button" value="Add a Person" /></a>'
                : '';
            return $output;
        }

        $fx = new myFunctions();

        $output = '<table class="paged"><tr>
            <th>Lastname</th>
            <th>Firstname</th>
            <th>Middlename</th>
            <th>Suffix</th>
            </tr>';

        foreach ($datas as $d) {
            $personGender = $d['person_gender'] == 'm'
                ? 'Male'
                : 'Female';
            $personButtons = $this->renderPersonButtons($d);
            $personButtons = strlen($personButtons) > 0
                ? '<div class="hr-light"></div>'.$personButtons
                : $personButtons;

            $dId = $d['person_id'];
            $dLabel = $d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'];
            $dUrl = URL_BASE.'persons/read_person/'.$d['person_id'];
            $output .= '<tr class="data"  data-id="'.$dId.'"  data-label="'.$dLabel.'"  data-url="'.$dUrl.'/">
                <td>
                    '.$d['person_lastname'].'
                    <div class="data-more-details">
                    <b>'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'</b>
                    <div class="hr-light"></div>
                    Gender: '.$personGender.'<br />
                    Birthdate: '.$fx->dateToWords($d['person_birthdate']).'<br />
                    Address A: '.$d['person_address_a'].'<br />
                    Address B: '.$d['person_address_b'].'<br />
                    Contact No. 1: '.$d['person_contact_a'].'<br />
                    Contact No. 2: '.$d['person_contact_b'].'<br />
                    Email Address: '.$d['person_email'].'
                    '.$personButtons.'
                    </div>
                </td>
                <td>'.$d['person_firstname'].'</td>
                <td>'.$d['person_middlename'].'</td>
                <td>'.$d['person_suffix'].'</td>
                </tr>';
        }
        $output .= '</table>
            <div class="hr-light"></div>';
        $output .= $fx->isAccessible('Content Provider')
            ? '<a href="'.URL_BASE.'persons/create_person/" target="_blank"><input class="btn-green" type="button" value="Add a Person" /></a>'
            : '';
        return $output;
    }



    public function renderPersonInformations ($personDatas) {
        if ($personDatas == null)
            return 'Error: This person do not exists in our system.';

        $p = $personDatas;

        $fx = new myFunctions();
        $c_items = new controller_items();
        $c_owners = new controller_owners();
        $c_employees = new controller_employees();
        $c_accounts = new controller_accounts();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $personName = '<h3>'.$p['person_lastname'].', '.$p['person_firstname'].' '.$p['person_middlename'].' '.$p['person_suffix'].'</h3>';
        $ownedItems = $c_owners->displayOwnedItemsSummary('Person', $p['person_id'], false);

        if ($p['person_head_departments'] != null) {
            $departmentHeadOf = '';
            foreach ($p['person_head_departments'] as $pdDept) {
                $departmentHeadOf .= '<a class="btn-blue" href="'.URL_BASE.'departments/read_department/'.$pdDept['department_id'].'/">
                    '.$pdDept['department_name'].' ('.$pdDept['department_name_short'].')
                    </a>';
            }
        } else
            $departmentHeadOf = 'None';

        ob_start();
        $c_items->displayInventory('Person', $p['person_id']);
        $inventory = ob_get_clean();

        ob_start();
        $c_employees->displayEmploymentHistory($p['person_id']);
        $employmentHistory = ob_get_clean();

        ob_start();
        $c_accounts->displayPersonAccounts($p['person_id']);
        $systemAccounts = ob_get_clean();

        $buttons = $this->renderPersonButtons($p);

        $personGender = $p['person_gender'] == 'm' ? 'Male' : 'Female';
        $personIsEmployee = $p['person_is_employee'] ? 'Yes' : 'No';

        $output = $personName.'<div class="hr-light"></div>
            <div class="accordion-title">Biodata</div>
            <div class="accordion-content accordion-content-default">
            <table>
            <tr>
                <th>Firstname</th>
                <td>'.$p['person_firstname'].'</td>
                <th>Birthdate</th>
                <td>'.$fx->dateToWords($p['person_birthdate']).'</td>
                <th>Head Of</th>
                <td>'.$departmentHeadOf.'</td>
            </tr>
            <tr>
                <th>Middlename</th>
                <td>'.$p['person_middlename'].'</td>
                <th>Is Employee?</th>
                <td>'.$personIsEmployee.'</td>
                <th rowspan="4">Address</th>
                <td rowspan="2">'.$p['person_address_a'].'</td>
            </tr>
            <tr>
                <th>Lastname</th>
                <td>'.$p['person_lastname'].'</td>
                <th rowspan="3">Contact</th>
                <td>'.$p['person_contact_a'].'</td>
            </tr>
            <tr>
                <th>Suffix</th>
                <td>'.$p['person_suffix'].'</td>
                <td>'.$p['person_contact_b'].'</td>
                <td rowspan="2">'.$p['person_address_b'].'</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>'.$personGender.'</td>
                <td>'.$p['person_email'].'</td>
            </tr>
            </table>
            </div>

            <div class="accordion-title">Inventory</div>
            <div class="accordion-content">'.$inventory.'</div>

            <div class="accordion-title">Employment History</div>
            <div class="accordion-content">'.$employmentHistory.'</div>

            <div class="accordion-title">Available Accounts on the System</div>
            <div class="accordion-content">'.$systemAccounts.'</div>

            <div class="hr-light"></div>
            '.$buttons;
        return $output;
    }



    public function renderPersonButtons ($datas) {
        if ($datas == null)
            return '';

        $p = $datas;
        $fx = new myFunctions();

        $btnView = $fx->isAccessible('Viewer')
            ? '<a href="'.URL_BASE.'persons/read_person/'.$p['person_id'].'/">
                <input class="btn-blue" type="button" value="View Person" />
                </a>'
            : '';
        $btnUpdate = $fx->isAccessible('Viewer')
            ? '<a href="'.URL_BASE.'persons/update_person/'.$p['person_id'].'/">
                <input class="btn-green" type="button" value="Update Person" />
                </a>'
            : '';
        $btnDelete = $fx->isAccessible('Administrator')
            ? '<a href="'.URL_BASE.'persons/delete_person/'.$p['person_id'].'/">
                <input class="btn-red" type="button" value="Delete Person" />
                </a>'
            : '';
        $btnAddEmployment = $fx->isAccessible('Supervisor')
            ? '<a href="'.URL_BASE.'employees/create_employment/'.$p['person_id'].'/">
                <input class="btn-green" type="button" value="Add Employment" />
                </a>'
            : '';
        $btnCreateAccount = $fx->isAccessible('Administrator')
            ? '<a href="'.URL_BASE.'accounts/create_account/'.$p['person_id'].'/">
                <input class="btn-green" type="button" value="Create an Account for this Person" />
                </a>'
            : '';
        $buttons = $btnView
            .$btnUpdate
            .$btnDelete
            .$btnAddEmployment
            .$btnCreateAccount;
        return $buttons;
    }



    public function renderPersonName ($person) {
        $p = $person;
        if ($p != null) return $p['person_lastname'].', '.$p['person_firstname'].' '.$p['person_middlename'].' '.$p['person_suffix'];
        else return 'None';
    }

}
