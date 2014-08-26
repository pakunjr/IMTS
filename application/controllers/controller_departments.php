<?php

class controller_departments {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_departments();
        $this->view = new view_departments();
    }



    public function displayDepartmentInformations ($departmentId) {
        $department = $this->model->readDepartment($departmentId);
        echo $this->view->renderDepartmentInformations($department);
    }

}
