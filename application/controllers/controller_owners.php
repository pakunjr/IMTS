<?php

class controller_owners {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_owners();
        $this->view = new view_owners();
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

        switch ($searchFor) {
            case 'Person':
                $results = $this->model->searchOwners($searchFor, $keyword);
                break;

            case 'Department':
                $results = $this->model->searchOwners($searchFor, $keyword);
                break;

            default:
        }

        echo $this->view->renderSearchResults($searchFor, $results);
    }



    public function displayOwnedItems ($ownerType, $ownerId, $echo=true) {
        $ownerships = $this->model->readOwnedItems($ownerType, $ownerId);
        $output = $this->view->renderOwnedItems($ownerships);
        if (!$echo) return $output;
        echo $output;
    }



    public function displayOwnerName ($ownershipId, $echo=true) {
        $owner = $this->model->readOwner($ownershipId);
        $name = $this->view->renderOwnerName($owner);
        if (!$echo) return $name;
        echo $name;
    }

}
