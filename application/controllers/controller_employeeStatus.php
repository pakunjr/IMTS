<?php

class controller_employeeStatus {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_employeeStatus();
        $this->view = new view_employeeStatus();
    }



    public function displaySelectForm ($options=array(), $echo=true) {
        $status = $this->model->readStatuses();
        $output = $this->view->renderSelectForm($status, $options);
        if (!$echo) return $output;
        echo $output;
    }

}
