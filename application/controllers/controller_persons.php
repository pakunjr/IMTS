<?php

class controller_persons {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_persons();
        $this->view = new view_persons();
    }



    public function createPerson () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'persons/create_person/');
            return;
        }
        $personDatas = $this->model->createPerson($_POST);
        if ($personDatas == null)
            header('location: '.URL_BASE.'persons/create_person/');
        else
            header('location: '.URL_BASE.'persons/read_person/'.$personDatas['person-id'].'/');
    }



    public function updatePerson () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'persons/');
            return;
        }
        $personDatas = $this->model->updatePerson($_POST);
        header('location: '.URL_BASE.'persons/read_person/'.$personDatas['person-id'].'/');
    }



    public function displayForm ($personId=null) {
        $personData = $this->model->readPerson($personId);
        echo $this->view->renderForm($personData);
    }



    public function displaySearchForm () {
        $keyword = isset($_POST['search-keyword']) ? $_POST['search-keyword'] : '';
        echo $this->view->renderSearchForm($keyword);
        $this->displaySearchResults($keyword);
    }



    public function displaySearchResults ($keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'You can search using the following:<br /><br />'
                .'Firstname<br />'
                .'Middlename<br />'
                .'Lastname<br /><br />'
                .'Email Address';
            return;
        }
        $keyword = trim($keyword);
        $searchResults = $this->model->searchPersons($keyword);
        echo $this->view->renderSearchResults($searchResults);
    }



    public function displayPersonInformations ($personId) {
        $personDatas = $this->model->readPerson($personId);
        if ($personDatas != null) {
            $personDatas['person_is_employee'] = $this->model->isEmployee($personId);
            $personDatas['person_head_departments'] = $this->model->readPersonHeadDepartments($personId);
        }
        echo $this->view->renderPersonInformations($personDatas);
    }



    public function displayPersonName ($personId, $echo=true) {
        $person = $this->model->readPerson($personId);
        $personName = $this->view->renderPersonName($person);
        if (!$echo) return $personName;
        echo $personName;
    }

}
