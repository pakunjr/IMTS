<?php

class view_departments {

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

        $output = $departmentName.$f->openForm(array('id'=>'', 'class'=>'main-form', 'action'=>$actionLink, 'method'=>'post', 'enctype'=>'multipart/form-data'))
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
        $c_persons = new controller_persons();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $ownerName = '<h3>'.$d['department_name'].' - '.$d['department_name_short'].'</h3>';
        $ownedItems = $c_owners->displayOwnedItemsSummary('Department', $d['department_id'], false);

        $headName = $c_persons->displayPersonName($d['department_head'], false);
        $headLink = !in_array($headName, array('Unknown Person', 'None'))
            ? '<a href="'.URL_BASE.'persons/read_person/'.$d['department_head'].'/"><input type="button" value="'.$headName.'" /></a>'
            : $headName;

        $output = $ownerName.'<hr />'
            .'<div class="accordion-title">Department Information</div><div class="accordion-content accordion-content-default">'
            .'<table>'
            .'<tr>'
                .'<th>Name</th>'
                .'<td>'.$d['department_name'].'</td>'
                .'<th rowspan="3">Description</th>'
                .'<td rowspan="3">'.nl2br($d['department_description']).'</td>'
            .'</tr><tr>'
                .'<th>Short</th>'
                .'<td>'.$d['department_name_short'].'</td>'
            .'</tr><tr>'
                .'<th>Head</th>'
                .'<td>'.$headLink.'</td>'
            .'</tr>'
            .'</table>'
            .'</div>'

            .'<div class="accordion-title">Owned Items and History</div><div class="accordion-content">'.$ownedItems.'</div>'

            .'<div class="accordion-title">Members</div><div class="accordion-content">'.$c_departments->displayDepartmentMembers($d['department_id'], false).'</div>'

            .'<div class="accordion-title">Ex-Members</div><div class="accordion-content">'.$c_departments->displayDepartmentExMembers($d['department_id'], false).'</div>'

            .'<hr />';
        $output .= !in_array($accessLevel, array('Viewer'))
                ? '<a href="'.URL_BASE.'departments/update_department/'.$d['department_id'].'/"><input class="btn-green" type="button" value="Update Department" /></a>'
                : '';
        return $output;
    }



    public function renderDepartmentMembers ($datas) {
        if ($datas == null) return 'There are no members for this department.';

        $fx = new myFunctions();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $output = '<table><tr>'
            .'<th>Name</th>'
            .'<th>Position</th>'
            .'<th>Status</th>'
            .'<th>Employment Date</th>'
            .'<th>Resignation / End of Contract Date</th>';
        $output .= !in_array($accessLevel, array('Viewer'))
                ? '<th>Actions</th>' : '';
        $output .= '</tr>';
        foreach ($datas as $d) {
            $output .= '<tr class="data" data-url="'.URL_BASE.'persons/read_person/'.$d['person_id'].'/">'
                .'<td>'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'</td>'
                .'<td>'.$d['employee_job_label'].'</td>'
                .'<td>'.$d['employee_status_label'].'</td>'
                .'<td>'.$fx->dateToWords($d['employee_employment_date']).'</td>'
                .'<td>'.$fx->dateToWords($d['employee_resignation_date']).'</td>';
            $output .= !in_array($accessLevel, array('Viewer'))
                    ? '<td><a href="'.URL_BASE.'persons/update_person/'.$d['person_id'].'/"><input class="btn-green" type="button" value="Update Person" /></a></td>'
                    : '';
            $output .= '</tr>';
        }
        $output .= '</table>';
        return $output;
    }



    public function renderDepartmentExMembers ($datas) {
        if ($datas == null) return 'There are no ex-members for this department.';

        $fx = new myFunctions();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $output = '<table><tr>'
            .'<th>Name</th>'
            .'<th>Position</th>'
            .'<th>Status</th>'
            .'<th>Employment Date</th>'
            .'<th>Resignation / End of Contract Date</th>';
        $output .= !in_array($accessLevel, array('Viewer'))
                ? '<th>Actions</th>' : '';
        $output .= '</tr>';
        foreach ($datas as $d) {
            $output .= '<tr class="data" data-url="'.URL_BASE.'persons/read_person/'.$d['person_id'].'/">'
                .'<td>'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'</td>'
                .'<td>'.$d['employee_job_label'].'</td>'
                .'<td>'.$d['employee_status_label'].'</td>'
                .'<td>'.$fx->dateToWords($d['employee_employment_date']).'</td>'
                .'<td>'.$fx->dateToWords($d['employee_resignation_date']).'</td>';
            $output .= !in_array($accessLevel, array('Viewer'))
                    ? '<td><a href="'.URL_BASE.'persons/update_person/'.$d['person_id'].'/"><input class="btn-green" type="button" value="Update Person" /></a></td>'
                    : '';
            $output .= '</tr>';
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

        $output = $f->openForm(array('id'=>'', 'method'=>'post', 'action'=>URL_BASE.'departments/search_department/')).$f->text(array('id'=>'search-keyword', 'label'=>'Search', 'value'=>$keyword)).$f->submit(array('value'=>'Search')).$f->closeForm().'<hr />';
        return $output;
    }



    public function renderSearchResults ($datas) {
        if ($datas == null) return 'Your keyword did not match any department name.<hr /><a href="'.URL_BASE.'departments/create_department/" target="_blank"><input class="btn-green" type="button" value="Add a Department" /></a>';

        $c_persons = new controller_persons();
        $accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;

        $output = '<table><tr>'
            .'<th>Name -- Short</th>'
            .'<th>Description</th>'
            .'<th>Head</th>';
        if (isset($_POST['search-keyword'])) {
            $output .= !in_array($accessLevel, array('Viewer'))
                ? '<th>Actions</th>' : '';
        }
        $output .= '</tr>';
        foreach ($datas as $d) {
            $headName = $c_persons->displayPersonName($d['department_head'], false);
            $headLink = isset($_POST['search-keyword']) && $headName != 'None'
                ? '<a href="'.URL_BASE.'persons/read_person/'.$d['department_head'].'/"><input type="button" value="'.$headName.'" /></a>'
                : $headName;

            $output .= '<tr class="data" '
                .'data-id="'.$d['department_id'].'" '
                .'data-label="'.$d['department_name_short'].' -- '.$d['department_name'].'" '
                .'data-url="'.URL_BASE.'departments/read_department/'.$d['department_id'].'/">'
                .'<td>'.$d['department_name'].' -- '.$d['department_name_short'].'</td>'
                .'<td>'.nl2br($d['department_description']).'</td>'
                .'<td>'.$headLink.'</td>';
            if (isset($_POST['search-keyword'])) {
                $output .= !in_array($accessLevel, array('Viewer'))
                    ? '<td><a href="'.URL_BASE.'departments/update_department/'.$d['department_id'].'/"><input class="btn-green" type="button" value="Update Department" /></a></td>'
                    : '';
            }
            $output .= '</tr>';
        }
        $output .= '</table>'
            .'<hr />';
        $output .= !in_array($accessLevel, array('Viewer'))
            ? '<a href="'.URL_BASE.'departments/create_department/" target="_blank"><input class="btn-green" type="button" value="Add a Department" /></a>'
            : '';
        return $output;
    }

}
