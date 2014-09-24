<?php

class controller_itemMaintenance {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_itemMaintenance();
        $this->view = new view_itemMaintenance();
    }



    public function __destruct () {

    }

}
