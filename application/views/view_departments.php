<?php

class view_departments {

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

}
