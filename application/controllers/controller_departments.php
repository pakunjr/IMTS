<?php

class controller_departments {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_departments();
        $this->view = new view_departments();
    }



    public function createDepartment () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'departments/');
            return;
        }
        $departmentDatas = $this->model->createDepartment($_POST);
    }



    public function updateDepartment () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'departments/');
            return;
        }
        $departmentDatas = $this->model->updateDepartment($_POST);
    }



    public function displayForm ($departmentId=null) {
        $department = $this->model->readDepartment($departmentId);
        echo $this->view->renderForm($department);
    }



    public function displayDepartmentInformations ($departmentId) {
        $department = $this->model->readDepartment($departmentId);
        echo $this->view->renderDepartmentInformations($department);
    }

}
