<?php

class controller_itemPackages {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_itemPackages();
        $this->view = new view_itemPackages();
    }



    public function createPackage () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'inventory_packages/create_package/');
            return;
        }
        $package = $this->model->createPackage($_POST);
        if ($package != null) {
            header('location: '.URL_BASE.'inventory_packages/read_package/'.$package['package-id'].'/');
        } else header('location: '.URL_BASE.'inventory_packages/create_package/');
    }



    public function updatePackage () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'inventory_packages/');
            return;
        }
        $package = $this->model->updatePackage($_POST);
        header('location: '.URL_BASE.'inventory_packages/read_package/'.$package['package-id'].'/');
    }



    public function displayForm ($packageId=null) {
        $package = $this->model->readPackage($packageId);
        echo $this->view->renderForm($package);
    }



    public function displayPackageInformations ($packageId) {
        $packageDatas = $this->model->readPackage($packageId);
        echo $this->view->renderPackageInformations($packageDatas);
    }



    public function displayPackageItems ($packageId, $echo=true) {
        $items = $this->model->readPackageItems($packageId);
        $output = $this->view->renderPackageItems($items);
        if (!$echo) return $output;
        echo $output;
    }



    public function displayPackageName ($packageId, $echo=true) {
        $package = $this->model->readPackage($packageId);
        $packageName = $this->view->renderPackageName($package);
        if (!$echo) return $packageName;
        echo $packageName;
    }



    public function displaySearchForm () {
        $keyword = isset($_POST['search-keyword']) ? $_POST['search-keyword'] : '';
        echo $this->view->renderSearchForm($keyword);
        $this->displaySearchResults($keyword);
    }



    public function displaySearchResults ($keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'Keywords can match the ff:<br /><br />'
                ,'Package Name<br />'
                ,'Package Serial No';
            return;
        }
        $keyword = trim($keyword);
        $results = $this->model->searchPackages($keyword);
        echo $this->view->renderSearchResults($results);
    }

}
