<?php

class controller_employees {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_employees();
        $this->view = new view_employees();
    }



    public function createEmployment () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'persons/');
            return;
        }
        $employment = $this->model->createEmployment($_POST);
        header('location: '.URL_BASE.'persons/read_person/'.$employment['employee-person'].'/');
    }



    public function updateEmployment () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'persons/');
            return;
        }
        $employment = $this->model->updateEmployment($_POST);
        header('location: '.URL_BASE.'persons/read_person/'.$employment['employee-person'].'/');
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



    public function displaySearchResultsJob ($keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'You can use the following to key-in your keyword:<br /><br />'
                .'Job Name'
                .'<hr /><a href="#"><input type="button" value="Add a Job" /></a>';
            return;
        }
        $keyword = trim($keyword);
        $searchResults = $this->model->searchJobs($keyword);
        echo $this->view->renderSearchResultsJob($searchResults);
    }



    public function displayJobName ($jobId, $echo=true) {
        $job = $this->model->readJob($jobId);
        $output = $this->view->renderJobName($job);
        if (!$echo) return $output;
        echo $output;
    }

}
