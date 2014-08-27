<?php

class view_employees {

    public function renderForm ($personId, $datas) {
        $d = $datas;
        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));
        $c_persons = new controller_persons();
        $c_employees = new controller_employees();
        $c_employeeStatus = new controller_employeeStatus();

        $employmentName = $d != null
            ? '<h3>'.$d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'].' as <br />'.$d['employee_job_label'].'</h3>'
            : '<h3>New Employment for <br />'.$c_persons->displayPersonName($personId, false).'</h3>';
        $actionLink = $d != null
            ? URL_BASE.'employees/update_employment/'
            : URL_BASE.'employees/create_employment/';

        $output = $employmentName.$f->openForm(array('id'=>'', 'action'=>$actionLink, 'method'=>'post', 'enctype'=>'multipart/form-data'))

            .$f->hidden(array('id'=>'employee-person', 'value'=>$personId))

            .$f->openFieldset(array('legend'=>'Employment Details'))
            .'<span class="column">'
            .$f->text(array('id'=>'employee-no', 'label'=>'Employee No.', 'value'=>$d != null ? $d['employee_no'] : ''))
            .$c_employeeStatus->displaySelectForm(array(), false)
            .$f->hidden(array('id'=>'employee-department', 'value'=>$d != null ? $d['employee_department'] : '0', 'data-url'=>URL_BASE.'departments/in_search/'))
            .$f->text(array('id'=>'employee-department-label', 'label'=>'Department', 'value'=>$d != null ? $d['employee_department'] : ''))
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
