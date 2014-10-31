<?php

class ControllerProfiles extends ViewProfiles
{
    
    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    public function displayHomepage ()
    {
        echo $this->renderHomepage();
    }



    public function displayProfileForm ()
    {
        echo $this->renderProfileForm();
    }



    public function displayChangePasswordForm ()
    {
        echo $this->renderChangePasswordForm();
    }

}
