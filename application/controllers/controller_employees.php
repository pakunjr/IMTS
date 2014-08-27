<?php

class controller_employees {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_employees();
        $this->view = new view_employees();
    }



    public function displaySearchResults ($keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'You can use the following to key-in your keyword:<br /><br />'
                .'Firstname<br />'
                .'Middlename<br />'
                .'Lastname<br /><br />'
                .'Job Position';
            return;
        }

        $searchResults = $this->model->searchEmployees($keyword);
        echo $this->view->renderSearchResults($searchResults);
    }

}
