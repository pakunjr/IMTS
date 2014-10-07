<?php

class view_employees {

    private $employeeStatus;

    public function __construct () {
        $fx = new myFunctions();
        $this->employeeStatus = $fx->enumSelectOptions('imts_persons_employment', 'employee_status');
    }



    public function __destruct () {

    }



    public function renderForm ($personId, $datas) {
        $d = $datas;
        $f = new form(array(
            'auto_line_break'=>true
            ,'auto_label'=>true));
        $c_persons = new controller_persons();
        $c_departments = new controller_departments();
        $c_employees = new controller_employees();

        $personName = $d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'];

        $employmentName = $d != null
            ? '<h3>'.$personName.'<br />
                '.$d['employee_job_label'].'</h3>'
            : '<h3>New Employment for <br />'.$c_persons->displayPersonName($personId, false).'</h3>';
        $actionLink = $d != null
            ? URL_BASE.'employees/update_employment/'.$personId.'/save/'
            : URL_BASE.'employees/create_employment/'.$personId.'/save/';

        $endEmploymentButton = $d != null
            ? '<a href="'.URL_BASE.'employees/end_employment/'.$d['employee_id'].'/">'.$f->button(array('class'=>'btn-red', 'value'=>'End Employment')).'</a>'
            : '';

        $output = $employmentName
            .'<div class="hr-light"></div>'
            .$f->openForm(array(
                'id'=>''
                ,'class'=>'main-form'
                ,'action'=>$actionLink
                ,'method'=>'post'
                ,'enctype'=>'multipart/form-data'))

            .$f->hidden(array(
                'id'=>'employee-id'
                ,'value'=>$d != null ? $d['employee_id'] : '0'))
            .$f->hidden(array(
                'id'=>'employee-person'
                ,'value'=>$personId))

            .$f->openFieldset(array('legend'=>'Employment Details'))
            .'<span class="column">'
            .$f->text(array(
                'id'=>'employee-no', 'label'=>'Employee No.', 'value'=>$d != null ? $d['employee_no'] : ''))
            .$f->select(array(
                'id' => 'employee-status'
                ,'label' => 'Status'
                ,'select_options' => $this->employeeStatus
                ,'default_option' => $d != null
                    ? $d['employee_status']
                    : ''))
            .$f->hidden(array(
                'id'=>'employee-department'
                ,'value'=>$d != null ? $d['employee_department'] : '0'
                ,'data-url'=>URL_BASE.'departments/in_search/'))
            .$f->text(array(
                'id'=>'employee-department-label'
                ,'label'=>'Department'
                ,'value'=>$d != null 
                    ? $c_departments->displayDepartmentName($d['employee_department'], false) 
                    : ''))
            .'</span>

            <span class="column">'
            .$f->hidden(array(
                'id'=>'employee-job'
                ,'value'=>$d != null ? $d['employee_job'] : '0'
                ,'data-url'=>URL_BASE.'employees/in_search_job/'))
            .$f->text(array(
                'id'=>'employee-job-label'
                ,'label'=>'Job Definition'
                ,'value'=>$d != null ? $c_employees->displayJobName($d['employee_job'], false) : ''))
            .$f->text(array(
                'id'=>'employee-employment-date'
                ,'class'=>'datepicker'
                ,'label'=>'Employment Date'
                ,'value'=>$d != null ? $d['employee_employment_date'] : ''))
            .$f->text(array(
                'id'=>'employee-resignation-date'
                ,'class'=>'datepicker'
                ,'label'=>'Resignation Date'
                ,'value'=>$d != null ? $d['employee_resignation_date'] : ''))
            .'</span>'
            .$f->closeFieldset()

            .'<div class="hr-light"></div>'
            .$f->submit(array(
                'value'=>$d != null ? 'Update Employment' : 'Save Employment'
                ,'auto_line_break'=>false))
            .'<a href="'.URL_BASE.'persons/read_person/'.$personId.'/">
            '.$f->button(array(
                'auto_line_break'=>false
                ,'value'=>'Cancel')).'
            </a>'
            .$endEmploymentButton
            .$f->closeForm();
        return $output;
    }



    public function renderFormJob ($datas) {
        $d = $datas;
        $f = new form(array('auto_line_break'=>true, 'auto_label'=>true));

        $actionLink = $d != null
            ? URL_BASE.'employees/update_job/save/'
            : URL_BASE.'employees/create_job/save/';

        $jobName = $d != null
            ? '<h3>'.$d['employee_job_label'].'</h3>'
            : '<h3>New Job</h3>';

        $output = $jobName.$f->openForm(array(
                'id'=>''
                ,'class'=>'main-form'
                ,'method'=>'post'
                ,'action'=>$actionLink
                ,'enctype'=>'multipart/form-data'))
            .$f->hidden(array(
                'id'=>'employee-job-id'
                ,'value'=>$d != null ? $d['employee_job_id'] : '0'))
            .$f->openFieldset(array('legend'=>'Job Information'))
            .'<span class="column">'
            .$f->text(array(
                'id'=>'employee-job-label'
                ,'label'=>'Job Label'
                ,'value'=>$d != null ? $d['employee_job_label'] : ''))
            .'</span>
            <span class="column">'
            .$f->textarea(array(
                'id'=>'employee-job-description'
                ,'label'=>'Description'
                ,'value'=>$d != null
                    ? $d['employee_job_description']
                    : ''))
            .'</span>'
            .$f->closeFieldset()
            .$f->submit(array('value'=>$d != null ? 'Update Job' : 'Save Job'))
            .$f->closeForm();
        return $output;
    }



    public function renderEmploymentHistory ($datas) {
        if ($datas == null)
            return 'This person has no employment history.';

        $d = $datas;
        $fx = new myFunctions();
        $c_departments = new controller_departments();

        $history = '';
        foreach ($datas as $d) {
            $departmentName = $c_departments->displayDepartmentName($d['employee_department'], false);
            $departmentLink = $departmentName != 'None'
                ? '<a class="btn-blue" href="'.URL_BASE.'departments/read_department/'.$d['employee_department'].'/">
                    '.$departmentName.'
                    </a>'
                : $departmentName;

            $jobDescription = strlen($d['employee_job_description'])
                ? '<br />Job Description:<br />
                    '.nl2br($d['employee_job_description'])
                : '';

            $buttons = $this->buttons($d);
            $buttons = strlen($buttons) > 0
                ? '<div class="hr-light"></div>
                    '.$buttons
                : '';

            $history .= '<tr>
                <td>
                    '.$d['employee_job_label'].'
                    <div class="data-more-details">
                        Employee No.: '.$d['employee_no'].'<br />
                        Designated Department: '.$departmentLink.'
                        '.$jobDescription.'
                        '.$buttons.'
                    </div>
                </td>
                <td>'.$d['employee_status'].'</td>
                <td>'.$fx->dateToWords($d['employee_employment_date']).'</td>
                <td>'.$fx->dateToWords($d['employee_resignation_date']).'</td>
                </tr>';
        }

        $output = '<table class="paged"><tr>
            <th>Job Definition</th>
            <th>Status</th>
            <th>Employment Date</th>
            <th>Resignation / End of Contract Date</th>
            </tr>
            '.$history.'
            </table>';
        return $output;
    }



    public function renderEmploymentButtons ($employeeId, $personId) {
        $fx = new myFunctions();
        $c_employees = new controller_employees();
        $currentDate = date('Y-m-d');
        $datas = $c_employees->getEmployeeDetails($employeeId);

        $btnUpdate = '<a href="'.URL_BASE.'employees/update_employment/'.$personId.'/'.$employeeId.'/">
                        <input class="btn-green" type="button" value="Update Employment" />
                        </a>';

        $btnEndEmployment = '<a href="'.URL_BASE.'employees/end_employment/'.$employeeId.'/">
                        <input class="btn-red" type="button" value="End Employment" />
                        </a>';

        $buttons = $datas['employee_resignation_date'] > $currentDate
                || $datas['employee_resignation_date'] == '0000-00-00'
            ? $btnUpdate.$btnEndEmployment
            : 'N/A';
        return $buttons;
    }



    public function buttons ($datas) {
        if ($datas === null)
            return null;

        $fx = new myFunctions();

        $currentDate = date('Y-m-d');
        $employeeId = $datas['employee_id'];
        $personId = $datas['employee_person'];

        $btnUpdate = '<a href="'.URL_BASE.'employees/update_employment/'.$personId.'/'.$employeeId.'/">
                        <input class="btn-green" type="button" value="Update Employment" />
                        </a>';

        $btnEndEmployment = '<a href="'.URL_BASE.'employees/end_employment/'.$employeeId.'/">
                        <input class="btn-red" type="button" value="End Employment" />
                        </a>';

        $o = $datas['employee_resignation_date'] > $currentDate
                || $datas['employee_resignation_date'] == '0000-00-00'
            ? $btnUpdate
                .$btnEndEmployment
            : '';
        return $o;
    }



    public function renderSearchResults ($datas) {
        if ($datas == null)
            return 'There are no employee matching your keyword.<div class="hr-light"></div><a href="'.URL_BASE.'persons/search_person/" target="_blank"><input class="btn-green" type="button" value="Search a Person" /></a>';

        $fx = new myFunctions();

        $output = '<table class="paged"><tr>
            <th>Name</th>
            <th>Job Position -- Description</th>
            <th>Employed Date</th>
            <th>Resignation / End of Contract Date</th>
            </tr>';
        foreach ($datas as $d) {
            $pId = $d['person_id'];
            $pName = $d['person_lastname'].', '.$d['person_firstname'].' '.$d['person_middlename'].' '.$d['person_suffix'];
            $output .= '<tr class="data" data-id="'.$pId.'" data-label="'.$pName.'">
                <td>'
                    .$pName.'
                </td>
                <td>'.$d['employee_job_label'].' -- '.nl2br($d['employee_job_description']).'</td>
                <td>'.$fx->dateToWords($d['employee_employment_date']).'</td>
                <td>'.$fx->dateToWords($d['employee_resignation_date']).'</td>
                </tr>';
        }
        $output .= '</table>
            <div class="hr-light"></div>
            <a href="'.URL_BASE.'persons/search_person/" target="_blank">
            <input class="btn-green" type="button" value="Search a Person" />
            </a>';
        return $output;
    }



    public function renderSearchFormJob ($keyword) {
        $f = new form(array('auto_line_break'=>false, 'auto_label'=>true));
        $output = $f->openForm(array('id'=>'', 'method'=>'post', 'action'=>URL_BASE.'employees/search_job/', 'enctype'=>'mutlipart/form-data'))
            .$f->text(array('id'=>'search-keyword', 'label'=>'Search', 'value'=>$keyword))
            .$f->submit(array('value'=>'Search'))
            .$f->closeForm().'<div class="hr-light"></div>';
        return $output;
    }



    public function renderSearchResultsJob ($datas) {
        $fx = new myFunctions();

        if ($datas == null) {
            $output = 'Your keyword did not match any Job name.<div class="hr-light"></div>';
            $output .= $fx->isAccessible('Supervisor')
                ? '<a href="'.URL_BASE.'employees/create_job/" target="_blank">
                    <input class="btn-green" type="button" value="Add a Job" />
                    </a>'
                : '';
            return $output;
        }

        $output = '<table><tr>
            <th>Label</th>
            <th>Description</th>';
        if (isset($_POST['search-keyword'])) {
            $output .= $fx->isAccessible('Supervisor')
                ? '<th>Actions</th>'
                : '';
        }
        $output .= '</tr>';
        foreach ($datas as $d) {
            $jId = $d['employee_job_id'];
            $jLabel = $d['employee_job_label'];
            $jUrl = URL_BASE.'employees/read_job/'.$d['employee_job_id'];
            $output .= '<tr class="data" data-id="'.$jId.'" data-label="'.$jLabel.'" data-url="'.$jUrl.'/">
                <td>'.$d['employee_job_label'].'</td>
                <td>'.nl2br($d['employee_job_description']).'</td>';
            if (isset($_POST['search-keyword'])) {
                $output .= $fx->isAccessible('Supervisor')
                    ? '<td>
                        <a href="'.URL_BASE.'employees/update_job/'.$d['employee_job_id'].'/">
                        <input class="btn-green" type="button" value="Update Job" />
                        </a>
                        </td>'
                    : '';
            }
            $output .= '</tr>';
        }
        $output .= '</table>
            <div class="hr-light"></div>';
        $output .= $fx->isAccessible('Supervisor')
            ? '<a href="'.URL_BASE.'employees/create_job/" target="_blank">
                <input class="btn-green" type="button" value="Add a Job" />
                </a>'
            : '';
        return $output;
    }



    public function renderJobInformations ($datas) {
        if ($datas == null) {
            header('location: '.URL_BASE.'employees/search_job/');
            return;
        }

        $d = $datas;
        $fx = new myFunctions();

        $output = '<h3>'.$d['employee_job_label'].'</h3>
            <div class="hr-light"></div>
            <table><tr>
            <th>Label</th>
            <th>Description</th>
            </tr>
            <tr>
            <td>'.$d['employee_job_label'].'</td>
            <td>'.nl2br($d['employee_job_description']).'</td>
            </tr>
            </table>
            <div class="hr-light"></div>';
        $output .= $fx->isAccessible('Supervisor')
                ? '<a href="'.URL_BASE.'employees/update_job/'.$d['employee_job_id'].'/">
                    <input class="btn-green" type="button" value="Update Job" />
                    </a>'
                : '';
        return $output;
    }



    public function renderJobName ($datas) {
        return $datas != null ? $datas['employee_job_label'] : '';
    }



    public function renderIsEmployee ($result) {
        return $result ? 'Yes' : 'No';
    }

}
