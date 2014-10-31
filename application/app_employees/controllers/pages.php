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
            case 'employee':
                $cPersons = new ControllerPersons();
                switch ($url[1]) {
                    case 'registration':
                        $cPersons->displayEmployeeForm();
                        break;

                    case 'update':
                        $cPersons->displayEmployeeForm();
                        break;

                    default:
                        header('location: '.URL_BASE);
                        exit();
                }
                break;

            case 'employment':
                $cPersons = new ControllerPersons();
                switch ($url[1]) {
                    case 'update':
                        $cPersons->displayEmploymentForm($url[2]);
                        break;

                    case 'end':
                        $cPersons->processEndEmployment($url[2]);
                        break;

                    default:
                        header('location: '.URL_BASE);
                        exit();
                }
                break;

            default:
                echo $this->renderHomepage();
        }

        $pageContents = ob_get_clean();
        $core->displayPage($pageContents, $pageContentsOnly);
    }

}
