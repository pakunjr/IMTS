<?php

class view_departments {

    public function __construct () {

    }



    public function __destruct () {

    }



    public function renderForm ($datas) {
        $d = $datas;

        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));

        $c_persons = new controller_persons();

        $departmentName = $d != null
            ? '<h3>'.$d['department_name_short'].' - '.$d['department_name'].'</h3>'
            : '<h3>New Department</h3>';

        $actionLink = $d != null
            ? URL_BASE.'departments/update_department/save/'
            : URL_BASE.'departments/create_department/save/';

        $cancelButton = $d != null
            ? '<a href="'.URL_BASE.'departments/read_department/'.$d['department_id'].'/'.'"><input type="button" value="Cancel" /></a>'
            : '';

        $output = $departmentName
            .'<div class="hr-light"></div>'
            .$f->openForm(array('id'=>'', 'class'=>'main-form', 'action'=>$actionLink, 'method'=>'post', 'enctype'=>'multipart/form-data'))
            .$f->hidden(array('id'=>'department-id', 'value'=>$d != null ? $d['department_id'] : '0'))

            .$f->openFieldset(array('legend'=>'Department Information'))
            .'<span class="column">'
            .$f->hidden(array('id'=>'department-head', 'value'=>$d != null ? $d['department_head'] : '0', 'data-url'=>URL_BASE.'employees/in_search/'))
            .$f->text(array('id'=>'department-head-label', 'label'=>'Head', 'value'=>$d != null ? $c_persons->displayPersonName($d['department_head'], false) : ''))
            .$f->text(array('id'=>'department-name', 'label'=>'Name', 'value'=>$d != null ? $d['department_name'] : ''))
            .$f->text(array('id'=>'department-name-short', 'label'=>'Short', 'value'=>$d != null ? $d['department_name_short'] : ''))
            .'</span>'

            .'<span class="column">'
            .$f->textarea(array('id'=>'department-description', 'label'=>'Description', 'value'=>$d != null ? $d['department_description'] : ''))
            .'</span>'
            .$f->closeFieldset()

            .'<div class="hr-light"></div>'
            .$f->submit(array('value'=>$d != null ? 'Update Department' : 'Save Department', 'auto_line_break'=>false))
            .$cancelButton
            .$f->closeForm();
        return $output;
    }



    public function renderDepartmentInformations ($datas) {
        if ($datas == null) return 'Error: This department do not exists in our system.';

        $d = $datas;

        $c_departments = new controller_departments();
        $c_owners = new controller_owners();
        $c_inventory = new controller_inventory();
        $c_persons = new controller_persons();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $ownerName = '<h3>'.$d['department_name'].' - '.$d['department_name_short'].'</h3>';

        $headName = $c_persons->displayPersonName($d['department_head'], false);
        $headLink = !in_array($headName, array('Unknown Person', 'None'))
            ? '<a href="'.URL_BASE.'persons/read_person/'.$d['department_head'].'/"><input type="button" value="'.$headName.'" /></a>'
            : $headName;

        ob_start();
        $c_inventory->displayInventory('Department', $d['department_id']);
        $inventory = ob_get_clean();

        ob_start();
        $c_departments->displayDepartmentMembers($d['department_id']);
        $dMembers = ob_get_clean();

        ob_start();
        $c_departments->displayDepartmentExMembers($d['department_id']);
        $dMembersEx = ob_get_clean();

        $output = $ownerName.'<div class="hr-light"></div>
            <div class="accordion-title">Department Information</div>
            <div class="accordion-content accordion-content-default">
            <table>
            <tr>
                <th>Name</th>
                <td>'.$d['department_name'].'</td>
                <th rowspan="3">Description</th>
                <td rowspan="3">'.nl2br($d['department_description']).'</td>
            </tr>
            <tr>
                <th>Short</th>
                <td>'.$d['department_name_short'].'</td>
            </tr>
            <tr>
                <th>Head</th>
                <td>'.$headLink.'</td>
            </tr>
            </table>
            </div>

            <div class="accordion-title">Inventory</div>
            <div class="accordion-content">'.$inventory.'</div>

            <div class="accordion-title">Present Members</div>
            <div class="accordion-content">'.$dMembers.'</div>

            <div class="accordion-title">Members History</div>
            <div class="accordion-content">'.$dMembersEx.'</div>

            <div class="hr-light"></div>';
        $output .= !in_array($accessLevel, array('Viewer'))
                ? '<a href="'.URL_BASE.'departments/update_department/'.$d['department_id'].'/"><input class="btn-green" type="button" value="Update Department" /></a>'
                : '';
        return $output;
    }



    public function renderDepartmentHeadName ($datas) {
        if ($datas == null)
            return 'None';

        $d = $datas;
        return $d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'];
    }



    public function renderDepartmentMembers ($datas) {
        if ($datas == null)
            return 'There are no members for this department.';

        $fx = new myFunctions();
        $c_persons = new controller_persons();

        $output = '<table><tr>
            <th>Lastname</th>
            <th>Firstname</th>
            <th>Middlename</th>
            <th>Suffix</th>
            </tr>';
        foreach ($datas as $d) {
            $personButtons = $c_persons->displayPersonButtons($d['person_id'], false);
            $personButtons = strlen($personButtons) > 0
                ? '<div class="hr-light"></div>'.$personButtons
                : $personButtons;
            $output .= '<tr class="data" data-url="'.URL_BASE.'persons/read_person/'.$d['person_id'].'/">
                <td>
                    '.$d['person_lastname'].'
                    <div class="data-more-details">
                    <b>'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'</b>
                    <div class="hr-light"></div>
                    Position: '.$d['employee_job_label'].'<br />
                    Status: '.$d['employee_status_label'].'<br />
                    Employed Date: '.$fx->dateToWords($d['employee_employment_date']).'<br />
                    Resigned / End of Contract Date: '.$fx->dateToWords($d['employee_resignation_date']).'
                    '.$personButtons.'
                    </div>
                </td>
                <td>'.$d['person_firstname'].'</td>
                <td>'.$d['person_middlename'].'</td>
                <td>'.$d['person_suffix'].'</td>
                </tr>';
        }
        $output .= '</table>';
        return $output;
    }



    public function renderDepartmentExMembers ($datas) {
        if ($datas == null)
            return 'There are no ex-members for this department.';

        $fx = new myFunctions();
        $c_persons = new controller_persons();

        $output = '<table><tr>
            <th>Lastname</th>
            <th>Firstname</th>
            <th>Middlename</th>
            <th>Suffix</th>
            </tr>';
        foreach ($datas as $d) {
            $personButtons = $c_persons->displayPersonButtons($d['person_id'], false);
            $personButtons = strlen($personButtons) > 0
                ? '<div class="hr-light"></div>'.$personButtons
                : $personButtons;
            $output .= '<tr class="data" data-url="'.URL_BASE.'persons/read_person/'.$d['person_id'].'/">
                <td>
                    '.$d['person_lastname'].'
                    <div class="data-more-details">
                    <b>'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'</b>
                    <div class="hr-light"></div>
                    Position: '.$d['employee_job_label'].'<br />
                    Status: '.$d['employee_status_label'].'<br />
                    Employed Date: '.$fx->dateToWords($d['employee_employment_date']).'<br />
                    Resigned / End of Contract Date: '.$fx->dateToWords($d['employee_resignation_date']).'
                    '.$personButtons.'
                    </div>
                </td>
                <td>'.$d['person_firstname'].'</td>
                <td>'.$d['person_middlename'].'</td>
                <td>'.$d['person_suffix'].'</td>
                </tr>';
        }
        $output .= '</table>';
        return $output;
    }



    public function renderDepartmentName ($datas) {
        $d = $datas;
        return $d != null ? $d['department_name_short'].' -- '.$d['department_name'] : 'None';
    }



    public function renderSearchForm ($keyword) {
        $f = new form(array('auto_line_break'=>false, 'auto_label'=>true));

        $output = $f->openForm(array('id'=>'', 'method'=>'post', 'action'=>URL_BASE.'departments/search_department/')).$f->text(array('id'=>'search-keyword', 'label'=>'Search', 'value'=>$keyword)).$f->submit(array('value'=>'Search')).$f->closeForm().'<div class="hr-light"></div>';
        return $output;
    }



    public function renderSearchResults ($datas) {
        if ($datas == null)
            return 'Your keyword did not match any department name.
                <div class="hr-light"></div>
                <a href="'.URL_BASE.'departments/create_department/" target="_blank">
                <input class="btn-green" type="button" value="Add a Department" />
                </a>';

        $fx = new myFunctions();
        $c_persons = new controller_persons();

        $output = '<table>
            <tr>
                <th>Short</th>
                <th>Name</th>
            </tr>';
        foreach ($datas as $d) {
            $departmentHead = $c_persons->displayPersonName($d['department_head'], false);
            $departmentHead = $departmentHead != 'None'
                ? '<a class="btn-blue" href="'.URL_BASE.'persons/read_person/'.$d['department_head'].'/">
                    '.$departmentHead.'
                    </a>'
                : $departmentHead;
            $departmentDescription = strlen($d['department_description']) > 0
                ? 'Description:<br />'.nl2br($d['department_description'])
                : '';
            $departmentButtons = $this->renderDepartmentButtons($d);
            $departmentButtons = strlen($departmentButtons) > 0
                ? '<div class="hr-light"></div>'.$departmentButtons
                : '';

            $dId = $d['department_id'];
            $dLabel = '('.$d['department_name_short'].') '.$d['department_name'];
            $dUrl = URL_BASE.'departments/read_department/'.$d['department_id'].'/';
            $output .= '<tr class="data" data-id="'.$dId.'" data-label="'.$dLabel.'" data-url="'.$dUrl.'">
                <td>
                    '.$d['department_name_short'].'
                    <div class="data-more-details">
                    <b>('.$d['department_name_short'].') '.$d['department_name'].'</b>
                    <div class="hr-light"></div>
                    Department Head: '.$departmentHead.'<br />
                    '.$departmentDescription.'
                    '.$departmentButtons.'
                    </div>
                </td>
                <td>'.$d['department_name'].'</td>
                </tr>';
        }
        $output .= '</table>';
        $output .= $fx->isAccessible('Content Provider')
            ? '<div class="hr-light"></div>
                <a href="'.URL_BASE.'departments/create_department/" target="_blank">
                <input class="btn-green" type="button" value="Add a Department" />
                </a>'
            : '';
        return $output;
    }



    public function renderDepartmentButtons ($datas) {
        if ($datas == null)
            return null;

        $fx = new myFunctions();
        $d = $datas;

        $btnUpdate = $fx->isAccessible('Content Provider')
            ? '<a href="'.URL_BASE.'departments/update_department/'.$d['department_id'].'/">
                <input class="btn-green" type="button" value="Update Department" />
                </a>'
            : '';
        $btnDelete = $fx->isAccessible('Administrator')
            ? '<a href="'.URL_BASE.'departments/delete_department/'.$d['department_id'].'/">
                <input class="btn-red" type="button" value="Delete Department" />
                </a>'
            : '';

        $buttons = $btnUpdate.$btnDelete;
        return $buttons;
    }

}
