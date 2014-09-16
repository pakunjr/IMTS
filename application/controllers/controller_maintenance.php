<?php

class controller_maintenance {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_maintenance();
        $this->view = new view_maintenance();
    }



    public function __destruct () {

    }

}
