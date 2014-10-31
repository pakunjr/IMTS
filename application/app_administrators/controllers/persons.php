<?php

class ControllerPersons extends ViewPersons
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    public function getRenderedPersonEmployments ($personId)
    {
        return $this->renderPersonEmployments($personId);
    }



    public function displayPersonEmployments ($personId)
    {
        echo $this->renderPersonEmployments($personId);
    }



    public function displaySearchedPersons ()
    {
        if (empty($_POST['search-keyword'])) {
            return 'Your keyword is empty and the system cannot search with an empty keyword.';
        }
        echo $this->renderSearchedPersons($_POST['search-keyword']);
    }

}
