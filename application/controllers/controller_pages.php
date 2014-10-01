<?php

class controller_pages {

    private $model;
    private $view;

    private $url;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_pages();
        $this->view = new view_pages();

        $this->url = $_SESSION['url'];
        $this->model->routeUrl($this->url);
    }



    public function __destruct () {

    }



    public function renderPages () {
        $model = $this->model->get('model');
        $view = $this->model->get('view');
        $controller = $this->model->get('controller');
        $action = $this->model->get('action');
        $extra = $this->model->get('extra');

        $db = new database();
        $fx = new myFunctions();
        $c_accounts = new controller_accounts();
        $c_items = new controller_items();
        $c_itemPackages = new controller_itemPackages();
        $c_itemMaintenance = new controller_itemMaintenance();
        $c_owners = new controller_owners();
        $c_persons = new controller_persons();
        $c_employees = new controller_employees();
        $c_departments = new controller_departments();
        $c_errors = new controller_errors();

        $models_authenticated = array('accounts', 'admin', 'inventory', 'inventory_packages', 'persons', 'employees', 'departments', 'owners');
        $models_public = array('home', 'track');
        $models_admin = array('admin');

        /**
         * Check authentication and
         * start preliminary routing
         * base on the result of the
         * checking
         */
        ob_start();
        if (in_array($model, $models_public)) {
            // Route pages in public modules
            switch ($model) {
                case 'home':
                    $this->displayHomepage();
                    $this->displayPage(ob_get_clean());
                    break;

                default:
                    $this->displayPageError('404');
            }
            return;
        } else if (in_array($model, $models_authenticated)) {
            if (!isset($_SESSION['user'])) {
                if ($model == 'accounts') {
                    if ($view != 'login')
                        $this->displayPageError('403');
                } else
                    $this->displayPageError('403');
            }
        }
        ob_end_clean();

        $acc_al = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;
        $acc_aid = isset($_SESSION['user']) ? $_SESSION['user']['accountId'] : null;

        /**
         * Route pages
         */
        ob_start();
        switch ($model) {
            case 'documents':
                // Printable media - Output file is in PDF format
                $c_documents = new controller_documents();
                switch ($view) {
                    /** Administrator documents **/

                    case 'system_log_report':
                        if ($fx->isAccessible('Administrator')) {

                        }
                        break;

                    /** Supervisor documents **/

                    /** Content Provider documents **/

                    case 'profile_card':
                        if ($fx->isAccessible('Content Provider'))
                            $c_documents->generateProfileCard($controller);
                        break;

                    case 'item_trace':
                        if ($fx->isAccessible('Content Provider'))
                            $c_documents->generateItemTrace($controller);
                        break;

                    case 'inventory_report':
                        if ($fx->isAccessible('Content Provider'))
                            $c_documents->generateInventoryReport($controller, $action);
                        break;

                    default:
                        $this->displayPageError('404');
                }
                break;

            case 'accounts':
                switch ($view) {
                    case 'login':
                        $c_accounts->loginUser();
                        break;

                    case 'logout':
                        $c_accounts->logoutUser();
                        break;

                    case 'create_account':
                        $this->restrictPage('Administrator');
                        switch ($controller) {
                            case 'save':
                                $c_accounts->createAccount();
                                break;

                            default:
                            $c_accounts->displayForm($controller);
                            $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'read_account':
                        if ($acc_aid != $controller)
                            $this->restrictPage('Supervisor');

                        $c_accounts->displayAccountInformations($controller);
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'update_account':
                        if (!$fx->isAccessible('Administrator')) {
                            if ($action != $acc_aid)
                                $this->displayPageError('403');
                        }

                        switch ($controller) {
                            case 'save':
                                $c_accounts->updateAccount();
                                break;

                            default:
                            $c_accounts->displayForm($controller, $action);
                            $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'update_password':
                        if (!$fx->isAccessible('Administrator')) {
                            if ($controller != 'save') {
                                if ($controller != $acc_aid)
                                    $this->displayPageError('403');
                            }
                        }

                        switch ($controller) {
                            case 'save':
                                $c_accounts->updatePassword();
                                break;

                            default:
                                $c_accounts->displayChangePasswordForm($controller);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'activate_account':
                        $this->restrictPage('Administrator');
                        $c_accounts->activateAccount($controller);
                        break;

                    case 'deactivate_account':
                        $this->restrictPage('Administrator');
                        $c_accounts->deactivateAccount($controller);
                        break;

                    default:
                        $this->displayPageError('underconstruction');
                }
                break;

            case 'admin':
                $this->restrictPage('Administrator');
                switch ($view) {
                    case 'log':
                        switch ($controller) {
                            case 'errors':
                                $c_errors->displayLogList();
                                $this->displayPage(ob_get_clean());
                                break;

                            case 'database_errors':
                                switch ($action) {
                                    case 'clean':
                                        $db->cleanDatabaseErrors();
                                        header('location: '.URL_BASE.'admin/log/database_errors/');
                                        break;

                                    default:
                                        $db->displayDatabaseErrors();
                                        $this->displayPage(ob_get_clean());
                                }
                                break;

                            case 'actions':
                                break;

                            default:
                                $this->displayPageError('underconstruction');
                        }
                        break;

                    case 'phpinfo':
                        phpinfo();
                        $this->displayPage(ob_get_clean());
                        break;

                    default:
                        $this->displayPageError('underconstruction');
                }
                break;

            case 'inventory':
                switch ($view) {
                    case 'create_item':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_items->saveItem();
                                break;

                            default:
                                $c_items->displayForm();
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'create_item_niboti':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_items->saveItem();
                                break;

                            default:
                                $c_items->displayForm(null, $controller);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'create_item_addComponent':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_items->saveItem();
                                break;

                            default:
                                $c_items->displayForm(null, null, $controller);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'create_multiple_items':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_items->saveMultipleItems();
                                break;

                            default:
                                $c_items->displayFormMultipleItems();
                                $this->displayPage(ob_get_clean());

                        }
                        break;

                    case 'read_item':
                        $c_items->displayItem($controller);
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'update_item':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_items->updateItem();
                                break;

                            default:
                                $c_items->displayForm($controller);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'delete_item':
                        $this->restrictPage('Administrator');
                        $c_items->deleteItem($controller);
                        break;

                    case 'archive_item':
                        $this->restrictPage('Supervisor');
                        $c_items->archiveItem($controller);
                        break;

                    case 'search_item':
                        $c_items->displaySearchForm();
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'in_search_item':
                        $this->restrictPage('Content Provider');
                        $c_items->displaySearchResults('item', $controller);
                        $this->displayPage(ob_get_clean(), false);
                        break;

                    case 'in_search_componentHost':
                        $this->restrictPage('Content Provider');
                        $c_items->displaySearchResults('componentHosts', $controller);
                        $this->displayPage(ob_get_clean(), false);
                        break;

                    default:
                        $this->displayPageError('underconstruction');
                }
                break;

            case 'inventory_packages':
                switch ($view) {
                    case 'create_package':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_itemPackages->createPackage();
                                break;

                            default:
                                $c_itemPackages->displayForm();
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'read_package':
                        $c_itemPackages->displayPackageInformations($controller);
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'update_package':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_itemPackages->updatePackage();
                                break;

                            default:
                                $c_itemPackages->displayForm($controller);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'search_package':
                        $c_itemPackages->displaySearchForm();
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'in_search':
                        $c_itemPackages->displaySearchResults($controller);
                        $this->displayPage(ob_get_clean(), false);
                        break;

                    default:
                        $this->displayPageError('underconstruction');
                }
                break;

            case 'inventory_maintenance':
                switch ($view) {
                    case 'create_maintenance':
                        switch ($controller) {
                            case 'save':
                                $c_itemMaintenance->saveItemMaintenance();
                                break;
                                
                            default:
                                $c_itemMaintenance->formItemMaintenance(array(
                                    'type' => 'create'
                                    ,'itemId' => $controller));
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'read_maintenance':
                        $this->displayPageError('underconstruction');
                        break;

                    case 'update_maintenance':
                        switch ($controller) {
                            case 'save':
                                $c_itemMaintenance->updateItemMaintenance();
                                break;
                                
                            default:
                                $c_itemMaintenance->formItemMaintenance(array(
                                    'type' => 'update'
                                    ,'maintenanceId' => $controller));
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'search_maintenance':
                        $this->displayPageError('underconstruction');
                        break;

                    default:
                        $this->displayPageError('404');
                }
                break;

            case 'persons':
                switch ($view) {
                    case 'create_person':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_persons->createPerson();
                                break;

                            default:
                                $c_persons->displayForm();
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'read_person':
                        $c_persons->displayPersonInformations($controller);
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'update_person':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_persons->updatePerson();
                                break;

                            default:
                                $c_persons->displayForm($controller);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'search_person':
                        $c_persons->displaySearchForm();
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'in_search_person':
                        $c_persons->displaySearchResults($controller);
                        $this->displayPage(ob_get_clean(), false);
                        break;

                    default:
                        $this->displayPageError('underconstruction');
                }
                break;

            case 'employees':
                switch ($view) {
                    case 'create_employment':
                        $this->restrictPage('Supervisor');
                        switch ($action) {
                            case 'save':
                                $c_employees->createEmployment();
                                break;

                            default:
                                $c_employees->displayForm($controller);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'create_job':
                        $this->restrictPage('Supervisor');
                        switch ($controller) {
                            case 'save':
                                $c_employees->createJob();
                                break;

                            default:
                                $c_employees->displayFormJob();
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'read_job':
                        $c_employees->displayJobInformations($controller);
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'update_employment':
                        $this->restrictPage('Supervisor');
                        switch ($action) {
                            case 'save':
                                $c_employees->updateEmployment();
                                break;

                            default:
                                $c_employees->displayForm($controller, $action);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'update_job':
                        $this->restrictPage('Supervisor');
                        switch ($controller) {
                            case 'save':
                                $c_employees->updateJob();
                                break;

                            default:
                                $c_employees->displayFormJob($controller);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'delete_job':
                        $this->restrictPage('Administrator');
                        $c_employees->deleteJob($controller);
                        break;

                    case 'end_employment':
                        $this->restrictPage('Supervisor');
                        $c_employees->endEmployment($controller);
                        break;

                    case 'search_job':
                        $c_employees->displaySearchFormJob();
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'in_search':
                        $c_employees->displaySearchResults($controller);
                        $this->displayPage(ob_get_clean(), false);
                        break;

                    case 'in_search_job':
                        $c_employees->displaySearchResultsJob($controller);
                        $this->displayPage(ob_get_clean(), false);
                        break;

                    default:
                        $this->displayPageError('underconstruction');
                }
                break;

            case 'departments':
                switch ($view) {
                    case 'create_department':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_departments->createDepartment();
                                break;

                            default:
                                $c_departments->displayForm();
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'read_department':
                        $c_departments->displayDepartmentInformations($controller);
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'update_department':
                        $this->restrictPage('Content Provider');
                        switch ($controller) {
                            case 'save':
                                $c_departments->updateDepartment();
                                break;

                            default:
                                $c_departments->displayForm($controller);
                                $this->displayPage(ob_get_clean());
                        }
                        break;

                    case 'search_department':
                        $c_departments->displaySearchForm();
                        $this->displayPage(ob_get_clean());
                        break;

                    case 'in_search':
                        $this->restrictPage('Content Provider');
                        ob_end_clean();
                        $c_departments->displaySearchResults($controller);
                        break;

                    default:
                        $this->displayPageError('underconstruction');
                }
                break;

            case 'owners':
                switch ($view) {
                    case 'in_search':
                        $this->restrictPage('Content Provider');
                        $c_owners->displaySearchResults($controller, $action);
                        $this->displayPage(ob_get_clean(), false);
                        break;

                    default:
                        $this->displayPageError('underconstruction');
                }
                break;

            case 'item_maintenance':
                switch ($view) {
                    case 'new_ticket':

                        break;
                }
                break;

            case 'home':
                $this->displayHomepage();
                $this->displayPage(ob_get_clean());
                break;

            default:
                $this->displayPageError('404');
        }
        ob_end_flush();
        exit();
    }



    public function displayBreadcrumb () {
        echo $this->view->renderBreadcrumb($this->model);
    }



    public function displayPage ($content, $complete=true) {
        $fileHeader = DIR_TEMPLATE.DS.'header.php';
        $fileFooter = DIR_TEMPLATE.DS.'footer.php';

        $fx = new myFunctions();

        ob_start();
        if ($complete) {
            ob_start();
            if (file_exists($fileHeader))
                require_once($fileHeader);
            else
                echo '<!-- TEMPLATE ERROR: Header, header.php file is missing. -->';

            ob_end_flush();
            ob_start();

            echo $content;

            if (file_exists($fileFooter))
                require_once($fileFooter);
            else
                echo '<!-- TEMPLATE ERROR: Footer, footer.php file is missing. -->';

            ob_end_flush();
        } else
            echo $content;

        $contents = ob_get_clean();
        // Check the environment of the application then
        // minify the html source code if the environment
        // is set to production
        if (ENVIRONMENT == 'PRODUCTION')
            $contents = str_replace(PHP_EOL, '', $contents);

        $contents = $fx->minifyString($contents);
        echo $contents;

        exit();
    }



    public function displayPageError ($type='unknown', $customErrorMsg='', $echo=true) {
        $output = $this->view->renderPageError($type, $customErrorMsg);
        if (!$echo)
            return $output;
        echo $output;
        exit();
    }



    public function displayHeader () {
        $file = DIR_TEMPLATE.DS.'header.php';
        if (file_exists($file))
            require_once($file);
        else
            echo 'Your header file is missing.';
    }



    public function displayFooter () {
        $file = DIR_TEMPLATE.DS.'footer.php';
        if (file_exists($file))
            require_once($file);
        else
            echo 'Your footer file is missing.';
    }



    public function displayHomepage () {
        $file = DIR_TEMPLATE.DS.'home.php';
        if (file_exists($file))
            require_once($file);
        else
            echo 'Your homepage file is missing.';
    }



    public function displayNavigation ($type='default') {
        $model = $this->model->get('model');
        echo $this->view->renderNavigation($type, $model);
    }



    public function restrictPage ($leastAccessLevel=null) {
        $fx = new myFunctions();
        if (!$fx->isAccessible($leastAccessLevel))
            $this->displayPageError('403');
    }



    public function pageRedirect ($msg, $redirectUrl) {
        $fx = new myFunctions();

        $msg .= '<div class="hr-light"></div>
            This page will automatically redirect in <span id="redirect-countdown" style="color: #f00; font-weight: bold;">10</span> seconds.';
        $msg = $fx->minifyString($msg);

        $o = '<script type="text/javascript">
            $(document).ready(function () {
                myAlert(\''.$msg.'\', function () {
                    window.location = \''.$redirectUrl.'\';
                });

                if ($("#redirect-countdown").length > 0) {
                    setInterval(function () {
                        var $timer = $("#redirect-countdown")
                            ,currentCount = parseInt($timer.html())
                            ,newCount = currentCount - 1;
                        $timer.html(newCount);
                    }, 1000);
                }

                setTimeout(function () {
                    window.location = \''.$redirectUrl.'\';
                }, 10000);
            });
            </script>';
        $this->displayPage($o);
    }

}
