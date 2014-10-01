<?php

class controller_departments {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_departments();
        $this->view = new view_departments();
    }



    public function __destruct () {

    }



    public function createDepartment () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'departments/create_department/';
            $c_pages->pageRedirect($m, $u);
        }

        $departmentDatas = $this->model->createDepartment($_POST);

        if ($departmentDatas != null) {
            $m = 'Department has been created successfully';
            $u = URL_BASE.'departments/read_department/'.$departmentDatas['department-id'].'/';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to create the department.';
            $u = URL_BASE.'departments/create_department/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function updateDepartment () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You can\'t access this page directly.';
            $u = URL_BASE.'departments/';
            $c_pages->pageRedirect($m, $u);
        }

        $departmentDatas = $this->model->updateDepartment($_POST);

        if ($departmentDatas != null) {
            $m = 'Successfully updated the department.';
            $u = URL_BASE.'departments/read_department/'.$departmentDatas['department-id'].'/';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to update the department.';
            $u = URL_BASE.'departments/read_department/'.$_POST['department-id'].'/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function displayForm ($departmentId=null) {
        $department = $this->model->readDepartment($departmentId);
        echo $this->view->renderForm($department);
    }



    public function displayDepartmentInformations ($departmentId) {
        $department = $this->model->readDepartment($departmentId);
        echo $this->view->renderDepartmentInformations($department);
    }



    public function displayDepartmentMembers ($departmentId, $echo=true) {
        $datas = $this->model->readDepartmentMembers($departmentId);
        $output = $this->view->renderDepartmentMembers($datas);
        if (!$echo) return $output;
        echo $output;
    }



    public function displayDepartmentExMembers ($departmentId, $echo=true) {
        $a = $this->model->readDepartmentExMembers($departmentId);
        $output = $this->view->renderDepartmentExMembers($a);
        if (!$echo) return $output;
        echo $output;
    }



    public function displaySearchForm () {
        $keyword = isset($_POST['search-keyword']) ? $_POST['search-keyword'] : '';
        echo $this->view->renderSearchForm($keyword);
        $this->displaySearchResults($keyword);
    }



    public function displaySearchResults ($keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'You can use the following to key-in your keyword:<br /><br />'
                .'Department Name / Short';
            return;
        }
        $keyword = trim($keyword);
        $departments = $this->model->searchDepartments($keyword);
        echo $this->view->renderSearchResults($departments);
    }



    public function displayDepartmentName ($departmentId, $echo=true) {
        $department = $this->model->readDepartment($departmentId);
        $output = $this->view->renderDepartmentName($department);
        if (!$echo) return $output;
        echo $output;
    }



    public function displayDepartmentHeadName ($departmentId, $echo=true) {
        $datas = $this->model->readDepartmentHead($departmentId);
        $name = $this->view->renderDepartmentHeadName($datas);
        if (!$echo)
            return $name;
        echo $name;
    }

}
