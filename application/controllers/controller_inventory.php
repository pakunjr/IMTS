<?php

class controller_inventory {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_inventory();
        $this->view = new view_inventory();
    }



    public function __destruct () {

    }



    public function displayInventory ($ownerType, $ownerId) {
        $datas = $this->model->fetchInventory($ownerType, $ownerId);
        echo $this->view->renderInventory($datas);
    }

}
