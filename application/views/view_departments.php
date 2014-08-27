<?php

class view_departments {

    public function renderForm ($datas) {
        $d = $datas;

        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));

        $c_persons = new controller_persons();

        $departmentName = $d != null
            ? '<h3>'.$d['department_name_short'].' - '.$d['department_name'].'</h3>'
            : '<h3>New Department</h3>';

        $output = $departmentName.$f->openForm(array('id'=>'', 'action'=>'', 'method'=>'post', 'enctype'=>'multipart/form-data'))
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

            .$f->submit(array('value'=>$d != null ? 'Update' : 'Save'))
            .$f->closeForm();
        return $output;
    }



    public function renderDepartmentInformations ($datas) {
        if ($datas == null) return 'Error: This department do not exists in our system.';

        $d = $datas;

        $c_owners = new controller_owners();
        $c_persons = new controller_persons();

        $ownerName = '<h3>'.$d['department_name'].' - '.$d['department_name_short'].'</h3>';
        $ownedItems = $c_owners->displayOwnedItems('Department', $d['department_id'], false);

        $output = $ownerName.'<hr />'
            .'<div class="accordion-title">Department Information</div><div class="accordion-content accordion-content-default">'
            .'<table>'
            .'<tr>'
                .'<th>Name</th>'
                .'<td>'.$d['department_name'].'</td>'
                .'<th rowspan="3">Description</th>'
                .'<td rowspan="3">'.$d['department_description'].'</td>'
            .'</tr><tr>'
                .'<th>Short</th>'
                .'<td>'.$d['department_name_short'].'</td>'
            .'</tr><tr>'
                .'<th>Head</th>'
                .'<td><a href="'.URL_BASE.'persons/read_person/'.$d['department_head'].'/"><input type="button" value="'.$c_persons->displayPersonName($d['department_head'], false).'" /></a></td>'
            .'</tr>'
            .'</table>'
            .'</div>'

            .'<div class="accordion-title">Ownership History</div><div class="accordion-content">'.$ownedItems.'</div>'

            .'<hr /><a href="'.URL_BASE.'departments/update_department/'.$d['department_id'].'/"><input class="btn-green" type="button" value="Update" /></a>';
        return $output;
    }



    public function renderSearchResults ($datas) {
        if ($datas == null) return 'Your keyword did not match any department name.';

        $c_persons = new controller_persons();

        $output = '<table><tr>'
            .'<th>Name -- Short</th>'
            .'<th>Description</th>'
            .'<th>Head</th>'
            .'</tr>';
        foreach ($datas as $d) {
            $output .= '<tr class="data" data-id="'.$d['department_id'].'" data-label="'.$d['department_name_short'].' -- '.$d['department_name'].'">'
                .'<td>'.$d['department_name'].' -- '.$d['department_name_short'].'</td>'
                .'<td>'.$d['department_description'].'</td>'
                .'<td>'.$c_persons->displayPersonName($d['department_head'], false).'</td>'
                .'</tr>';
        }
        $output .= '</table>'
            .'<hr /><a href="'.URL_BASE.'departments/create_department/" target="_blank"><input class="btn-green" type="button" value="Add a Department" /></a>';
        return $output;
    }

}
