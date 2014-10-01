<?php

class controller_employees {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_employees();
        $this->view = new view_employees();
    }



    public function __destruct () {

    }



    public function createEmployment () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'employees/create_employment/';
            $c_pages->pageRedirect($m, $u);
        }

        $employment = $this->model->createEmployment($_POST);

        if ($employment != null) {
            $m = 'Employment has been created successfully.';
            $u = URL_BASE.'persons/read_person/'.$employment['employee-person'].'/';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to create the employment';
            $u = URL_BASE.'employees/create_employment/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function createJob () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'employees/create_job/';
            $c_pages->pageRedirect($m, $u);
        }

        $job = $this->model->createJob($_POST);

        if ($job != null) {
            $m = 'Successfully created the job.';
            $u = URL_BASE.'employees/read_job/'.$job['employee-job-id'].'/';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to create the job.';
            $u = URL_BASE.'employees/create_job/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function updateEmployment () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'persons/';
            $c_pages->pageRedirect($m, $u);
        }

        $employment = $this->model->updateEmployment($_POST);

        if ($employment != null) {
            $m = 'Successfully updated the employment.';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to update the employment.';
        }

        $u = URL_BASE.'persons/read_person/'.$_POST['employee-person'].'/';
        $c_pages->pageRedirect($m, $u);
    }



    public function updateJob () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'employees/search_job/';
            $c_pages->pageRedirect($m, $u);
        }

        $job = $this->model->updateJob($_POST);

        if ($job != null) {
            $m = 'Successfully updated the job.';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to update the job.';
        }

        $u = URL_BASE.'employees/read_job/'.$_POST['employee-job-id'].'/';
        $c_pages->pageRedirect($m, $u);
    }



    public function deleteJob ($jobId) {
        $c_pages = new controller_pages();

        $res = $this->model->deleteJob($jobId);

        if ($res) {
            $m = 'Successfully deleted the job.';
            $u = URL_BASE.'employees/search_job/';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to delete the job.';
            $u = URL_BASE.'employees/read_job/'.$jobId.'/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function endEmployment ($employeeId) {
        $c_pages = new controller_pages();

        $status = $this->model->endEmployment($employeeId);

        if ($status) {
            $m = 'Successfully ended the employment.';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to end the employment.';
        }

        $employment = $this->model->readEmployee($employeeId);
        $u = URL_BASE.'persons/read_person/'.$employment['person_id'].'/';
        $c_pages->pageRedirect($m, $u);
    }



    public function displayForm ($personId=null, $employeeId=null) {
        if ($personId == null) {
            header('location: '.URL_BASE.'employees/');
            return;
        }
        $employee = $this->model->readEmployee($employeeId);
        echo $this->view->renderForm($personId, $employee);
    }



    public function displayFormJob ($jobId=null) {
        $jobDatas = $this->model->readJob($jobId);
        echo $this->view->renderFormJob($jobDatas);
    }



    public function displayEmploymentHistory ($personId, $echo=true) {
        $employment = $this->model->readPersonEmployment($personId);
        $output = $this->view->renderEmploymentHistory($employment);
        if (!$echo) return $output;
        echo $output;
    }



    public function displaySearchResults ($keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'You can use the following to key-in your keyword:<br /><br />'
                .'Firstname<br />'
                .'Middlename<br />'
                .'Lastname<br /><br />'
                .'Job Position';
            return;
        }
        $keyword = trim($keyword);
        $searchResults = $this->model->searchEmployees($keyword);
        echo $this->view->renderSearchResults($searchResults);
    }



    public function displaySearchFormJob () {
        $keyword = isset($_POST['search-keyword']) ? $_POST['search-keyword'] : '';
        echo $this->view->renderSearchFormJob($keyword);
        $this->displaySearchResultsJob($keyword);
    }



    public function displaySearchResultsJob ($keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'You can use the following to key-in your keyword:<br /><br />'
                .'Job Name';
            return;
        }
        $keyword = trim($keyword);
        $searchResults = $this->model->searchJobs($keyword);
        echo $this->view->renderSearchResultsJob($searchResults);
    }



    public function displayJobInformations ($jobId) {
        $jobDatas = $this->model->readJob($jobId);
        echo $this->view->renderJobInformations($jobDatas);
    }



    public function displayJobName ($jobId, $echo=true) {
        $job = $this->model->readJob($jobId);
        $output = $this->view->renderJobName($job);
        if (!$echo) return $output;
        echo $output;
    }



    public function isEmployee ($personId, $echo=true) {
        $result = $this->model->isEmployee($personId);
        $output = $this->view->renderIsEmployee($result);
        if (!$echo)
            return $output;
        echo $output;
    }



    public function getEmployeeDetails ($employeeId) {
        return $this->model->readEmployee($employeeId);
    }

}
