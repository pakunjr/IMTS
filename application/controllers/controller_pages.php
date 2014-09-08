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



    public function renderPages () {
        $model = $this->model->get('model');
        $view = $this->model->get('view');
        $controller = $this->model->get('controller');
        $action = $this->model->get('action');
        $extra = $this->model->get('extra');

        $db = new database();
        $c_accounts = new controller_accounts();
        $c_items = new controller_items();
        $c_itemPackages = new controller_itemPackages();
        $c_owners = new controller_owners();
        $c_persons = new controller_persons();
        $c_employees = new controller_employees();
        $c_departments = new controller_departments();
        $c_errors = new controller_errors();

        $models_authenticated = array('accounts', 'admin', 'inventory', 'inventory_packages', 'persons', 'employees', 'departments', 'owners');
        $models_public = array('home', 'track');
        $models_admin = array('admin');

        //Check authentication
        if (in_array($model, $models_public)) {
            //Route pages in public modules
            switch ($model) {
                case 'track':
                    switch ($view) {
                        case 'owner':
                            switch ($controller) {
                                case 'person':
                                case 'department':
                                    $this->displayHeader();
                                    $c_owners->displayTrackedItems(ucfirst($controller), $action);
                                    $this->displayFooter();
                                    break;

                                case 'person_printable':
                                case 'department_printable':
                                    $ownerType = $controller == 'person_printable' ? 'Person' : 'Department';
                                    $c_owners->pdfOwnedItems($ownerType, $action);
                                    break;

                                default:
                                    $this->displayHeader();
                                    $c_owners->displayTrackForm();
                                    $this->displayFooter();
                            }
                            break;

                        case 'item':
                            $this->displayHeader();
                            $this->displayErrorPage('underconstruction');
                            $this->displayFooter();
                            break;

                        default:
                            $this->displayHeader();
                            $this->displayErrorPage('404');
                            $this->displayFooter();
                    }
                    break;

                case 'home':
                    $this->displayHeader();
                    $this->displayHomepage();
                    $this->displayFooter();
                    break;

                default:
                    $this->displayHeader();
                    $this->displayErrorPage('404');
                    $this->displayFooter();
            }
            return;
        } else if (in_array($model, $models_authenticated)) {
            if (!isset($_SESSION['user'])) {
                if ($model == 'accounts') {
                    if ($view != 'login') {
                        $this->displayHeader();
                        $this->displayErrorPage('403');
                        $this->displayFooter();
                        return;
                    }
                } else {
                    $this->displayHeader();
                    $this->displayErrorPage('403');
                    $this->displayFooter();
                    return;
                }
            }
        }

        $acc_al = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;
        $acc_aid = isset($_SESSION['user']) ? $_SESSION['user']['accountId'] : null;

        //Route pages
        switch ($model) {
            case 'accounts':
                switch ($view) {
                    case 'login':
                        $c_accounts->loginUser();
                        break;

                    case 'logout':
                        $c_accounts->logoutUser();
                        break;

                    case 'create_account':
                        if (!in_array($acc_al, array('Administrator', 'Admin'))) {
                            $this->displayHeader();
                            $this->displayErrorPage('403');
                            $this->displayFooter();
                            return;
                        }

                        switch ($controller) {
                            case 'save':
                                $c_accounts->createAccount();
                                break;

                            default:
                            $this->displayHeader();
                            $c_accounts->displayForm($controller);
                            $this->displayFooter();
                        }
                        break;

                    case 'read_account':
                        $this->displayHeader();
                        $c_accounts->displayAccountInformations($controller);
                        $this->displayFooter();
                        break;

                    case 'update_account':
                        if (!in_array($acc_al, array('Administrator', 'Admin'))) {
                            if ($action != $acc_aid) {
                                $this->displayHeader();
                                $this->displayErrorPage('403');
                                $this->displayFooter();
                                return;
                            }
                        }

                        switch ($controller) {
                            case 'save':
                                $c_accounts->updateAccount();
                                break;

                            default:
                            $this->displayHeader();
                            $c_accounts->displayForm($controller, $action);
                            $this->displayFooter();
                        }
                        break;

                    case 'update_password':
                        if ($acc_al != 'Administrator' && $acc_al != 'Admin') {
                            if ($controller != 'save') {
                                if ($controller != $acc_aid) {
                                    $this->displayHeader();
                                    $this->displayErrorPage('403');
                                    $this->displayFooter();
                                    return;
                                }
                            }
                        }

                        switch ($controller) {
                            case 'save':
                                $c_accounts->updatePassword();
                                break;

                            default:
                                $this->displayHeader();
                                $c_accounts->displayChangePasswordForm($controller);
                                $this->displayFooter();
                        }
                        break;

                    case 'activate_account':
                        if (!in_array($acc_al, array('Administrator', 'Admin'))) {
                            $this->displayHeader();
                            $this->displayErrorPage('403');
                            $this->displayFooter();
                            return;
                        }

                        $c_accounts->activateAccount($controller);
                        break;

                    case 'deactivate_account':
                        if (!in_array($acc_al, array('Administrator', 'Admin'))) {
                            $this->displayHeader();
                            $this->displayErrorPage('403');
                            $this->displayFooter();
                            return;
                        }

                        $c_accounts->deactivateAccount($controller);
                        break;

                    default:
                        $this->displayHeader();
                        $this->displayErrorPage('underconstruction');
                        $this->displayFooter();
                }
                break;

            case 'admin':
                if (!in_array($acc_al, array('Administrator', 'Admin'))) {
                    $this->displayHeader();
                    $this->displayErrorPage('403');
                    $this->displayFooter();
                    return;
                }
                
                switch ($view) {
                    case 'log':
                        switch ($controller) {
                            case 'errors':
                                $this->displayHeader();
                                $c_errors->displayLogList();
                                $this->displayFooter();
                                break;

                            case 'database_errors':
                                switch ($action) {
                                    case 'clean':
                                        $db->cleanDatabaseErrors();
                                        header('location: '.URL_BASE.'admin/log/database_errors/');
                                        break;

                                    default:
                                        $this->displayHeader();
                                        $db->displayDatabaseErrors();
                                        $this->displayFooter();
                                }
                                break;

                            case 'actions':
                                break;

                            default:
                                $this->displayHeader();
                                $this->displayErrorPage('underconstruction');
                                $this->displayFooter();
                        }
                        break;

                    default:
                        $this->displayHeader();
                        $this->displayErrorPage('underconstruction');
                        $this->displayFooter();
                }
                break;

            case 'inventory':
                switch ($view) {
                    case 'create_item':
                        switch ($controller) {
                            case 'save':
                                $c_items->saveItem();
                                break;

                            default:
                                $this->displayHeader();
                                $c_items->displayForm();
                                $this->displayFooter();
                        }
                        break;

                    case 'create_item_niboti':
                        switch ($controller) {
                            case 'save':
                                $c_items->saveItem();
                                break;

                            default:
                                $this->displayHeader();
                                $c_items->displayForm(null, $controller);
                                $this->displayFooter();
                        }
                        break;

                    case 'create_item_addComponent':
                        switch ($controller) {
                            case 'save':
                                $c_items->saveItem();
                                break;

                            default:
                                $this->displayHeader();
                                $c_items->displayForm(null, null, $controller);
                                $this->displayFooter();
                        }
                        break;

                    case 'read_item':
                        $this->displayHeader();
                        $c_items->displayItem($controller);
                        $this->displayFooter();
                        break;

                    case 'update_item':
                        switch ($controller) {
                            case 'save':
                                $c_items->updateItem();
                                break;

                            default:
                                $this->displayHeader();
                                $c_items->displayForm($controller);
                                $this->displayFooter();
                        }
                        break;

                    case 'archive_item':
                        $c_items->archiveItem($controller);
                        break;

                    case 'search_item':
                        $this->displayHeader();
                        $c_items->displaySearchForm();
                        $this->displayFooter();
                        break;

                    case 'in_search_componentHost':
                        $c_items->displaySearchResults('componentHosts', $controller);
                        break;

                    default:
                        $this->displayHeader();
                        $this->displayErrorPage('underconstruction');
                        $this->displayFooter();
                }
                break;

            case 'inventory_packages':
                switch ($view) {
                    case 'create_package':
                        switch ($controller) {
                            case 'save':
                                $c_itemPackages->createPackage();
                                break;

                            default:
                                $this->displayHeader();
                                $c_itemPackages->displayForm();
                                $this->displayFooter();
                        }
                        break;

                    case 'read_package':
                        $this->displayHeader();
                        $c_itemPackages->displayPackageInformations($controller);
                        $this->displayFooter();
                        break;

                    case 'update_package':
                        switch ($controller) {
                            case 'save':
                                $c_itemPackages->updatePackage();
                                break;

                            default:
                                $this->displayHeader();
                                $c_itemPackages->displayForm($controller);
                                $this->displayFooter();
                        }
                        break;

                    case 'search_package':
                        $this->displayHeader();
                        $c_itemPackages->displaySearchForm();
                        $this->displayFooter();
                        break;

                    case 'in_search':
                        $c_itemPackages->displaySearchResults($controller);
                        break;

                    default:
                        $this->displayHeader();
                        $this->displayErrorPage('underconstruction');
                        $this->displayFooter();
                }
                break;

            case 'persons':
                switch ($view) {
                    case 'create_person':
                        switch ($controller) {
                            case 'save':
                                $c_persons->createPerson();
                                break;

                            default:
                                $this->displayHeader();
                                $c_persons->displayForm();
                                $this->displayFooter();
                        }
                        break;

                    case 'read_person':
                        $this->displayHeader();
                        $c_persons->displayPersonInformations($controller);
                        $this->displayFooter();
                        break;

                    case 'update_person':
                        switch ($controller) {
                            case 'save':
                                $c_persons->updatePerson();
                                break;

                            default:
                                $this->displayHeader();
                                $c_persons->displayForm($controller);
                                $this->displayFooter();
                        }
                        break;

                    case 'search_person':
                        $this->displayHeader();
                        $c_persons->displaySearchForm();
                        $this->displayFooter();
                        break;

                    default:
                        $this->displayHeader();
                        $this->displayErrorPage('underconstruction');
                        $this->displayFooter();
                }
                break;

            case 'employees':
                switch ($view) {
                    case 'create_employment':
                        switch ($action) {
                            case 'save':
                                $c_employees->createEmployment();
                                break;

                            default:
                                $this->displayHeader();
                                $c_employees->displayForm($controller);
                                $this->displayFooter();
                        }
                        break;

                    case 'create_job':
                        switch ($controller) {
                            case 'save':
                                $c_employees->createJob();
                                break;

                            default:
                                $this->displayHeader();
                                $c_employees->displayFormJob();
                                $this->displayFooter();
                        }
                        break;

                    case 'read_job':
                        $this->displayHeader();
                        $c_employees->displayJobInformations($controller);
                        $this->displayFooter();
                        break;

                    case 'update_employment':
                        switch ($action) {
                            case 'save':
                                $c_employees->updateEmployment();
                                break;

                            default:
                                $this->displayHeader();
                                $c_employees->displayForm($controller, $action);
                                $this->displayFooter();
                        }
                        break;

                    case 'update_job':
                        switch ($controller) {
                            case 'save':
                                $c_employees->updateJob();
                                break;

                            default:
                                $this->displayHeader();
                                $c_employees->displayFormJob($controller);
                                $this->displayFooter();
                        }
                        break;

                    case 'delete_job':
                        $c_employees->deleteJob($controller);
                        break;

                    case 'end_employment':
                        $c_employees->endEmployment($controller);
                        break;

                    case 'search_job':
                        $this->displayHeader();
                        $c_employees->displaySearchFormJob();
                        $this->displayFooter();
                        break;

                    case 'in_search':
                        $c_employees->displaySearchResults($controller);
                        break;

                    case 'in_search_job':
                        $c_employees->displaySearchResultsJob($controller);
                        break;

                    default:
                        $this->displayHeader();
                        $this->displayErrorPage('underconstruction');
                        $this->displayFooter();
                }
                break;

            case 'departments':
                switch ($view) {
                    case 'create_department':
                        switch ($controller) {
                            case 'save':
                                $c_departments->createDepartment();
                                break;

                            default:
                                $this->displayHeader();
                                $c_departments->displayForm();
                                $this->displayFooter();
                        }
                        break;

                    case 'read_department':
                        $this->displayHeader();
                        $c_departments->displayDepartmentInformations($controller);
                        $this->displayFooter();
                        break;

                    case 'update_department':
                        switch ($controller) {
                            case 'save':
                                $c_departments->updateDepartment();
                                break;

                            default:
                                $this->displayHeader();
                                $c_departments->displayForm($controller);
                                $this->displayFooter();
                        }
                        break;

                    case 'search_department':
                        $this->displayHeader();
                        $c_departments->displaySearchForm();
                        $this->displayFooter();
                        break;

                    case 'in_search':
                        $c_departments->displaySearchResults($controller);
                        break;

                    default:
                        $this->displayHeader();
                        $this->displayErrorPage('underconstruction');
                        $this->displayFooter();
                }
                break;

            case 'owners':
                switch ($view) {
                    case 'in_search':
                        $c_owners->displaySearchResults($controller, $action);
                        break;

                    default:
                        $this->displayHeader();
                        $this->displayErrorPage('underconstruction');
                        $this->displayFooter();
                }
                break;

            case 'home':
                $this->displayHeader();
                $this->displayHomepage();
                $this->displayFooter();
                break;

            default:
                $this->displayHeader();
                $this->displayErrorPage('404');
                $this->displayFooter();
        }
    }



    public function displayBreadcrumb () {
        echo $this->view->renderBreadcrumb($this->model);
    }



    public function displayHeader () {
        $file = DIR_TEMPLATE.DS.'header.php';
        if (file_exists($file)) require_once($file);
        else echo 'Your header file is missing.';
    }



    public function displayFooter () {
        $file = DIR_TEMPLATE.DS.'footer.php';
        if (file_exists($file)) require_once($file);
        else echo 'Your footer file is missing.';
    }



    public function displayHomepage () {
        $file = DIR_TEMPLATE.DS.'home.php';
        if (file_exists($file)) require_once($file);
        else echo 'Your homepage file is missing.';
    }



    public function displayNavigation ($type='default') {
        $model = $this->model->get('model');
        echo $this->view->renderNavigation($type, $model);
    }



    public function displayErrorPage ($type='unknown', $echo=true) {
        $output = $this->view->renderErrorPage($type);
        if (!$echo) return $output;
        echo $output;
    }

}
