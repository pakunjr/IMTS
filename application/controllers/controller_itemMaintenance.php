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



    public function formItemMaintenance ($options=array()) {
        $c_pages = new controller_pages();
        $type = $options['type'];

        if ($type == 'create') {
            $itemId = $options['itemId'];
        } else if ($type == 'update') {
            $maintenanceId = $options['maintenanceId'];
            $options['datas'] = $this->model->readItemMaintenance($maintenanceId);
        } else {
            $m = 'It seems like you are magically lost.<br /><br />Please wait while the system warp you back to the right path again.';
            $u = URL_BASE.'inventory_maintenance/create_maintenance/';
            $c_pages->pageRedirect($m, $u);
        }

        $form = $this->view->formItemMaintenance($options);
        echo $form;
    }



    public function saveItemMaintenance () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'inventory_maintenance/create_maintenance/';
            $c_pages->pageRedirect($m, $u);
        }

        $o = $this->model->createItemMaintenance($_POST);

        if ($o !== null) {
            $m = 'Successfully created the maintenance.';
            $u = URL_BASE.'inventory_maintenance/read_maintenance/'.$o['maintenance-id'].'/';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to create the maintenance.';
            $u = URL_BASE.'inventory_maintenance/create_maintenance/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function updateItemMaintenance () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'inventory_maintenance/create_maintenance/';
            $c_pages->pageRedirect($m, $u);
        }

        $o = $this->model->updateItemMaintenance($_POST);

        if ($o !== null) {
            $m = 'Successfully updated the maintenance.';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to update the maintenance.';
        }

        $u = URL_BASE.'inventory_maintenance/read_maintenance/'.$_POST['maintenance-id'].'/';
        $c_pages->pageRedirect($m, $u);
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
