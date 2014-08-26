<?php

class controller_itemPackages {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_itemPackages();
        $this->view = new view_itemPackages();
    }



    public function displayPackageName ($packageId, $echo=true) {
        $package = $this->model->readPackage($packageId);
        $packageName = $this->view->renderPackageName($package);
        if (!$echo) return $packageName;
        echo $packageName;
    }



    public function displaySearchResults ($keyword) {
        if (strlen(trim($keyword)) > 0) {
            $results = $this->model->searchPackages($keyword);
            echo $this->view->renderSearchResults($results);
        } else echo 'Keywords can match the ff:<br />'
            ,'Package Name<br />'
            ,'Package Serial No';
    }

}
