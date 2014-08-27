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



    public function displayPersonInformations ($personId) {
        $personDatas = $this->model->readPerson($personId);
        $personDatas['person_is_employee'] = $this->model->isEmployee($personId);
        $personDatas['person_head_departments'] = $this->model->readPersonHeadDepartments($personId);
        echo $this->view->renderPersonInformations($personDatas);
    }



    public function displayPersonName ($personId, $echo=true) {
        $person = $this->model->readPerson($personId);
        $personName = $this->view->renderPersonName($person);
        if (!$echo) return $personName;
        echo $personName;
    }

}
