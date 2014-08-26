<?php

class controller_persons {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_persons();
        $this->view = new view_persons();
    }



    public function displayForm ($personId=null) {

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
