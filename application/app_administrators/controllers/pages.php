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
        $pageContentsOnly = false;
        ob_start();

        switch ($url[0]) {
            case 'accounts':
                $cAccounts = new ControllerAccounts();
                switch ($url[1]) {
                    case 'registration':
                        $cAccounts->displayRegistrationForm();
                        break;

                    case 'registration_save':
                        $cAccounts->registerUser();
                        break;

                    case 'update_accounts':
                        $cAccounts->displayRegistrationForm();
                        break;

                    case 'update_accounts_save':
                        $cAccounts->updateUser();
                        break;

                    case 'check_accounts':
                        $cAccounts->checkAccounts();
                        break;

                    case 'search_account_owners':
                        $cPersons = new ControllerPersons();
                        $pageContentsOnly = true;
                        $cPersons->displaySearchedPersons();
                        break;

                    default:
                }
                break;
                
            default:
                echo $this->renderHomepage();
        }

        $pageContents = ob_get_clean();
        $core->displayPage($pageContents, $pageContentsOnly);
    }

}
