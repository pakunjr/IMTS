<?php

class controller_persons {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_persons();
        $this->view = new view_persons();
    }



    public function __destruct () {

    }



    public function createPerson () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'persons/create_person/';
            $c_pages->pageRedirect($m, $u);
        }

        $personDatas = $this->model->createPerson($_POST);

        if ($personDatas != null) {
            $m = 'Successfully saved the person.';
            $u = URL_BASE.'persons/read_person/'.$personDatas['person-id'].'/';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to save the person.';
            $u = URL_BASE.'persons/create_person/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function updatePerson () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You cant access this page directly.';
            $u = URL_BASE.'persons/create_person/';
            $c_pages->pageRedirect($m, $u);
        }

        $personDatas = $this->model->updatePerson($_POST);

        if ($personDatas != null) {
            $m = 'Successfully updated the person.';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to update the person.';
        }

        $u = URL_BASE.'persons/read_person/'.$_POST['person-id'].'/';
        $c_pages->pageRedirect($m, $u);
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
        if (!$echo)
            return $personName;
        echo $personName;
    }



    public function displayPersonButtons ($personId, $echo=true) {
        $datas = $this->model->readPerson($personId);
        $output = $this->view->renderPersonButtons($datas);
        if (!$echo)
            return $output;
        echo $output;
    }

}
