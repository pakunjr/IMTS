<?php

class ControllerAccounts extends ViewAccounts
{
    
    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    public function displayRegistrationForm ()
    {
        echo $this->renderRegistrationForm();
    }



    public function registerUser ()
    {
        $core = new SystemCore();
        $url = URL_BASE.'accounts/registration/';
        if (empty($_POST)) {
            $msg = 'Sorry but you cannot access this page directly.';
            $core->redirectPage($msg, $url);
        }

        exit(print_r($_POST, true));

        $status = $this->createAccount($_POST);
        if ($status) {
            $msg = 'The system successfully created the account.';
        } else {
            $msg = 'The system failed to create the account.';
        }
        $core->redirectPage($msg, $url);
    }



    public function updateUser ()
    {
        $core = new SystemCore();
        if (empty($_POST)) {
            $msg = 'Sorry but you cannot access this page directly.';
            $url = URL_BASE.'accounts/update_accounts/';
            $core->redirectPage($msg, $url);
        }
    }



    public function checkAccounts ()
    {
        echo $this->renderCheckAccounts();
    }

}
