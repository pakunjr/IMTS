<?php

class controller_owners {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_owners();
        $this->view = new view_owners();
    }



    public function displayTrackForm () {
        $keyword = isset($_POST['search-keyword']) ? $_POST['search-keyword'] : '';
        $keyword = trim($keyword);
        $searchFor = isset($_POST['search-for']) ? $_POST['search-for'] : 'Person';
        echo $this->view->renderTrackForm($searchFor, $keyword);
        $this->displaySearchResults($searchFor, $keyword);
    }



    public function displaySearchResults ($searchFor='Person', $keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'Keywords can match the ff:<br /><br />'
                ,'For Persons:<br />'
                ,'Firstname<br />'
                ,'Middlename<br />'
                ,'Lastname<br />'
                ,'Birthdate<br /><br />'
                ,'For Departments:<br />'
                ,'Name<br />'
                ,'Acronym';
            return;
        }
        $keyword = trim($keyword);

        if ($searchFor == 'Person')
            $results = $this->model->searchOwners($searchFor, $keyword);
        else if ($searchFor == 'Department')
            $results = $this->model->searchOwners($searchFor, $keyword);
        else
            $results = null;

        echo $this->view->renderSearchResults($searchFor, $results);
    }



    public function displayTrackedItems ($ownerType, $ownerId) {
        if ($ownerType == 'Person') {
            $c_persons = new controller_persons();
            $ownerName = $c_persons->displayPersonName($ownerId, false);
        } else if ($ownerType == 'Department') {
            $c_departments = new controller_departments();
            $ownerName = $c_departments->displayDepartmentName($ownerId, false);
        } else $ownerName = 'None';

        echo 'List of items owned by the ',$ownerType,', <b>',$ownerName,'</b><br />';
        $this->displayOwnedItemsSummary($ownerType, $ownerId);
    }



    public function displayOwnedItems ($ownerType, $ownerId, $echo=true) {
        $ownerships = $this->model->readOwnedItems($ownerType, $ownerId);
        $output = $this->view->renderOwnedItems($ownerships);
        if (!$echo) return $output;
        echo $output;
    }



    public function displayOwnedItemsSummary ($ownerType, $ownerId, $echo=true) {
        $ownerships = $this->model->readOwnedItems($ownerType, $ownerId);
        $output = $this->view->renderOwnedItemsSummary($ownerships);
        if (!$echo) return $output;
        echo $output;
    }



    public function displayOwnerName ($ownershipId, $echo=true) {
        $owner = $this->model->readOwner($ownershipId);
        $name = $this->view->renderOwnerName($owner);
        if (!$echo) return $name;
        echo $name;
    }



    public function pdfOwnedItems ($ownerType, $ownerId) {
        $ownerships = $this->model->readOwnedItems($ownerType, $ownerId);
        $output = $this->view->renderPdfOwnedItems($ownerships);

        if (strtolower($ownerType) == 'person') {
            $c_persons = new controller_persons();
            $ownerName = $c_persons->displayPersonName($ownerId, false);
        } else if (strtolower($ownerType) == 'department') {
            $c_departments = new controller_departments();
            $ownerName = $c_departments->displayDepartmentName($ownerId, false);
        } else {
            $ownerName = 'Unknown Owner';
        }

        $fx = new myFunctions();
        $fx->pdfCreate(array(
            'filename'=>'Items of '.$ownerName
            ,'content'=>$output));
    }

}
