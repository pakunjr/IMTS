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
            $options['datas'] = $this->model->readMaintenance($maintenanceId);
        } else {
            $m = 'It seems like you are magically lost.<br /><br />Please wait while the system warp you back to the right path again.<br /><br />Thank you.';
            $u = URL_BASE.'inventory_maintenance/create_maintenance/';
            $c_pages->pageRedirect($m, $u);
        }

        $form = $this->view->mainForm($options);
        echo $form;
    }



    public function saveItemMaintenance () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'inventory_maintenance/create_maintenance/';
            $c_pages->pageRedirect($m, $u);
        }

        $o = $this->model->createMaintenance($_POST);

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

        $o = $this->model->updateMaintenance($_POST);

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
    public function itemMaintenanceInformation ($maintenanceId) {
        $details = $this->model->readMaintenance($maintenanceId);
        echo $this->view->information($details);
    }



    // Display all maintenance done on an
    // item
    public function itemMaintenanceHistory ($itemId) {
        $details = $this->model->readMaintenances($itemId);
        echo $this->view->history($details);
    }



    public function search ($keyword, $for='maintenance') {
        switch ($for) {
            case 'staffs':
                $datas = $this->model->searchStaffs($keyword);
                break;

            case 'items':
                $datas = $this->model->searchItems($keyword);
                break;

            case 'maintenance':
            default:
                $datas = $this->model->searchMaintenances($keyword);
        }
        echo $this->view->searchResults($datas, $for);
    }



    public function fetchProgress ($maintenanceId) {
        return $this->model->readProgresses($maintenanceId);
    }

}
