<?php

class ControllerPages extends ViewPages
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    public function routePage ()
    {
        $core = new SystemCore();
        $url = explode('/', URL_REQUEST);
        ob_start();
        switch ($url[0]) {
            case 'validate_login':
                $cAccounts = new ControllerAccounts();
                $cAccounts->processLogin();
                break;

            case 'home':
            default:
                // Display login form
                echo $this->renderLoginForm();
        }
        $pageContents = ob_get_clean();
        $core->displayPage($pageContents);
    }

}
