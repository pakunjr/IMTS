<?php

class controller_mailer {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_mailer();
        $this->view = new view_mailer();
    }



    public function __destruct () {

    }

}
