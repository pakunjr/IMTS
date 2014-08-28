<?php

class view_employees {

    public function renderForm ($personId, $datas) {
        $d = $datas;
        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));
        $c_persons = new controller_persons();
        $c_departments = new controller_departments();
        $c_employees = new controller_employees();
        $c_employeeStatus = new controller_employeeStatus();

        $employmentName = $d != null
            ? '<h3>'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].' as <br />'.$d['employee_job_label'].'</h3>'
            : '<h3>New Employment for <br />'.$c_persons->displayPersonName($personId, false).'</h3>';
        $actionLink = $d != null
            ? URL_BASE.'employees/update_employment/'.$personId.'/save/'
            : URL_BASE.'employees/create_employment/'.$personId.'/save/';

        $output = $employmentName.$f->openForm(array('id'=>'', 'action'=>$actionLink, 'method'=>'post', 'enctype'=>'multipart/form-data'))

            .$f->hidden(array('id'=>'employee-id', 'value'=>$d != null ? $d['employee_id'] : '0'))
            .$f->hidden(array('id'=>'employee-person', 'value'=>$personId))

            .$f->openFieldset(array('legend'=>'Employment Details'))
            .'<span class="column">'
            .$f->text(array('id'=>'employee-no', 'label'=>'Employee No.', 'value'=>$d != null ? $d['employee_no'] : ''))
            .$c_employeeStatus->displaySelectForm(array(), false)
            .$f->hidden(array('id'=>'employee-department', 'value'=>$d != null ? $d['employee_department'] : '0', 'data-url'=>URL_BASE.'departments/in_search/'))
            .$f->text(array('id'=>'employee-department-label', 'label'=>'Department', 'value'=>$d != null ? $c_departments->displayDepartmentName($d['employee_department'], false) : ''))
            .'</span>'

            .'<span class="column">'
            .$f->hidden(array('id'=>'employee-job', 'value'=>$d != null ? $d['employee_job'] : '0', 'data-url'=>URL_BASE.'employees/in_search_job/'))
            .$f->text(array('id'=>'employee-job-label', 'label'=>'Job Definition', 'value'=>$d != null ? $c_employees->displayJobName($d['employee_job'], false) : ''))
            .$f->text(array('id'=>'employee-employment-date', 'class'=>'datepicker', 'label'=>'Employment Date', 'value'=>$d != null ? $d['employee_employment_date'] : ''))
            .$f->text(array('id'=>'employee-resignation-date', 'class'=>'datepicker', 'label'=>'Resignation Date', 'value'=>$d != null ? $d['employee_resignation_date'] : ''))
            .'</span>'
            .$f->closeFieldset()

            .$f->submit(array('value'=>$d != null ? 'Update' : 'Save'))
            .$f->closeForm();
        return $output;
    }



    public function renderEmploymentHistory ($datas) {
        if ($datas == null) return 'This person has no employment history.';

        $d = $datas;
        $fx = new myFunctions();
        $c_departments = new controller_departments();

        $currentDate = date('Y-m-d');

        $output = '<table><tr>'
            .'<th>Employee No</th>'
            .'<th>Status</th>'
            .'<th>Job Label -- Definition</th>'
            .'<th>Department Short -- Name</th>'
            .'<th>Employment Date</th>'
            .'<th>Resignation / End of Contract Date</th>'
            .'<th>Actions</th>'
            .'</tr>';
        foreach ($datas as $d) {
            $deptName = $c_departments->displayDepartmentName($d['employee_department'], false);
            $deptLink = $deptName != 'Unknown Department'
                ? '<a href="'.URL_BASE.'departments/read_department/'.$d['employee_department'].'/"><input type="button" value="'.$deptName.'" /></a>'
                : $deptName;

            $actionButtons = $d['employee_resignation_date'] > $currentDate || $d['employee_resignation_date'] == '0000-00-00'
                ? '<a href="'.URL_BASE.'employees/update_employment/'.$d['employee_person'].'/'.$d['employee_id'].'/"><input class="btn-green" type="button" value="Update Employment" /></a>'
                    .'<a href="'.URL_BASE.'employees/end_employment/'.$d['employee_id'].'/"><input class="btn-red" type="button" value="End Employment" /></a>'
                : 'N/A';

            $output .= '<tr>'
                .'<td>'.$d['employee_no'].'</td>'
                .'<td>'.$d['employee_status_label'].'</td>'
                .'<td>'.$d['employee_job_label'].' -- '.$d['employee_job_description'].'</td>'
                .'<td>'.$deptLink.'</td>'
                .'<td>'.$fx->dateToWords($d['employee_employment_date']).'</td>'
                .'<td>'.$fx->dateToWords($d['employee_resignation_date']).'</td>'
                .'<td>'
                    .$actionButtons
                .'</td>'
                .'</tr>';
        }
        $output .= '</table>';
        return $output;
    }



    public function renderSearchResults ($datas) {
        if ($datas == null) return 'There are no employee matching your keyword.';

        $fx = new myFunctions();

        $output = '<table><tr>'
            .'<th>Name</th>'
            .'<th>Job Position -- Description</th>'
            .'<th>Employed Date</th>'
            .'<th>Resignation / End of Contract Date</th>'
            .'</tr>';
        foreach ($datas as $d) {
            $output .= '<tr class="data" data-id="'.$d['person_id'].'" data-label="'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].'">'
                .'<td>'
                    .$d['person_lastname'].', '
                    .$d['person_firstname'].' '
                    .$d['person_middlename'].' '
                    .$d['person_suffix']
                .'</td>'
                .'<td>'.$d['employee_job_label'].' -- '.$d['employee_job_description'].'</td>'
                .'<td>'.$fx->dateToWords($d['employee_employment_date']).'</td>'
                .'<td>'.$fx->dateToWords($d['employee_resignation_date']).'</td>'
                .'</tr>';
        }
        $output .= '</table>';
        return $output;
    }



    public function renderSearchResultsJob ($datas) {
        if ($datas == null) return 'Your keyword did not match any Job name.';

        $output = '<table><tr>'
            .'<th>Label</th>'
            .'<th>Description</th>'
            .'</tr>';
        foreach ($datas as $d) {
            $output .= '<tr class="data" data-id="'.$d['employee_job_id'].'" data-label="'.$d['employee_job_label'].'">'
                .'<td>'.$d['employee_job_label'].'</td>'
                .'<td>'.$d['employee_job_description'].'</td>'
                .'</tr>';
        }
        $output .= '</table>';
        return $output;
    }



    public function renderJobName ($datas) {
        return $datas != null ? $datas['employee_job_label'] : '';
    }

}
