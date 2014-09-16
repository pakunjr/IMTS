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
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'persons/');
            return;
        }
        $employment = $this->model->createEmployment($_POST);
        header('location: '.URL_BASE.'persons/read_person/'.$employment['employee-person'].'/');
    }



    public function createJob () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'employees/create_job/');
            return;
        }
        $job = $this->model->createJob($_POST);
        if ($job != null) {
            header('location: '.URL_BASE.'employees/read_job/'.$job['employee-job-id'].'/');
        } else header('location: '.URL_BASE.'employees/create_job/');
    }



    public function updateEmployment () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'persons/');
            return;
        }
        $employment = $this->model->updateEmployment($_POST);
        header('location: '.URL_BASE.'persons/read_person/'.$employment['employee-person'].'/');
    }



    public function updateJob () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'employees/search_job/');
            return;
        }
        $job = $this->model->updateJob($_POST);
        header('location: '.URL_BASE.'employees/read_job/'.$_POST['employee-job-id'].'/');
    }



    public function deleteJob ($jobId) {
        $res = $this->model->deleteJob($jobId);
        if ($res) header('location: '.URL_BASE.'employees/search_job/');
        else header('location: '.URL_BASE.'employees/read_job/'.$jobId.'/');
    }



    public function endEmployment ($employeeId) {
        $this->model->endEmployment($employeeId);
        $employment = $this->model->readEmployee($employeeId);
        header('location: '.URL_BASE.'persons/read_person/'.$employment['person_id'].'/');
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
        if (!$echo) return $output;
        echo $output;
    }

}
