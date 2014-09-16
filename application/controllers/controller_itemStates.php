<?php

class controller_itemStates {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_itemStates();
        $this->view = new view_itemStates();
    }



    public function __destruct () {

    }



    public function displaySelectForm ($options=array(), $echo=true) {
        $states = $this->model->readItemStates();
        $form = $this->view->renderSelectForm($states, $options);
        if (!$echo) return $form;
        echo $form;
    }



    public function displayItemStateName ($stateId, $echo=true) {
        $itemState = $this->model->readItemState($stateId);
        $name = $this->view->renderItemStateName($itemState);
        if (!$echo) return $name;
        echo $name;
    }

}
