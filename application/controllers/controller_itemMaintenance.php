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



    public function formItemMaintenance ($maintenanceId) {
        $datas = $this->view->readItemMaintenance($maintenanceId);
        $form = $this->view->formItemMaintenance();
        echo $form;
    }



    public function saveItemMaintenance () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE);
            exit();
        }

        $o = $this->model->createItemMaintenance($_POST);

        if ($o != null) {
            // Maintenance information is
            // created successfully
            header('location: '.URL_BASE.'inventory_maintenance/read_maintenance/'.$o['maintenance-id'].'/');
            exit();
        } else {
            header('location: '.URL_BASE);
            exit();
        }
    }



    // Display detailed information of
    // a maintenance on an item
    public function maintenanceInformation ($maintenanceId) {

    }



    // Display all maintenance done on an
    // item
    public function maintenanceHistory () {

    }

}
