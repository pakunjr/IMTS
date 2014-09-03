<?php

class controller_errors {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_errors();
        $this->view = new view_errors();
    }



    public function logError ($details) {
        $res = $this->model->logError($details);
        return $res;
    }



    public function displayLogList () {
        $errors = $this->model->readErrors();
        echo $this->view->renderLogList($errors);
    }

}
