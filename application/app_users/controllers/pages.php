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

        switch ($url[1]) {
            case 'profile':
                $cProfiles = new ControllerProfiles();
                $cAccounts = new ControllerAccounts();

                switch ($url[2]) {
                    case 'change_password':
                        $cProfiles->displayChangePasswordForm();
                        break;

                    case 'save_password':
                        $cAccounts->saveChangePassword();
                        break;

                    case 'update_profile':
                        $cProfiles->displayProfileForm();

                    case 'save_profile':
                        break;

                    default:
                        $cProfiles->displayHomepage();
                }
                break;

            case 'logs':
                if ($_SESSION['user']['accessLevel'] !== 'Administrator') {
                    $msg = 'You do not have enough privilege to access neither the Database Log nor the System Log.';
                    $url = URL_BASE.'user_settings/profile/';
                    $core->redirectPage($msg, $url);
                }
                $cLogs = new ControllerLogs();
                switch ($url[2]) {
                    case 'database':
                        $cLogs->displayLogContent('database');
                        break;

                    case 'system_archives':
                        $cLogs->displayLogContent('system', 'Archived');
                        break;

                    case 'system':
                        $cLogs->displayLogContent('system');
                        break;

                    case 'clear':
                        switch ($url[3]) {
                            case 'database':
                                $cLogs->cleanLogs('database');
                                break;

                            case 'system':
                            default:
                                $cLogs->cleanLogs('system');
                        }
                        break;

                    default:
                        $cLogs->displayHomepage();
                }
                break;
                
            default:
                header('location: '.URL_BASE.'user_settings/profile/');
        }

        $pageContents = ob_get_clean();
        $core->displayPage($pageContents);
    }

}
