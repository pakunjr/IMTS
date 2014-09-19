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
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'departments/create_department/');
            return;
        }
        $departmentDatas = $this->model->createDepartment($_POST);
        if ($departmentDatas != null) {
            header('location: '.URL_BASE.'departments/read_department/'.$departmentDatas['department-id'].'/');
        } else header('location: '.URL_BASE.'departments/create_department/');
    }



    public function updateDepartment () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'departments/');
            return;
        }
        $departmentDatas = $this->model->updateDepartment($_POST);
        header('location: '.URL_BASE.'departments/read_department/'.$departmentDatas['department-id'].'/');
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
