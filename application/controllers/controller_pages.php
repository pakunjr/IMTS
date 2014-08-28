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

        $c_items = new controller_items();
        $c_itemPackages = new controller_itemPackages();
        $c_owners = new controller_owners();
        $c_persons = new controller_persons();
        $c_employees = new controller_employees();
        $c_departments = new controller_departments();

        switch ($model) {
            case 'admin':
                switch ($view) {
                    case 'log':
                        switch ($controller) {
                            case 'errors':
                                break;

                            case 'actions':
                                break;

                            default:
                        }
                        break;

                    default:
                        $this->displayHeader();
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

                    case 'end_employment':
                        $c_employees->endEmployment($controller);
                        break;

                    case 'in_search':
                        $c_employees->displaySearchResults($controller);
                        break;

                    case 'in_search_job':
                        $c_employees->displaySearchResultsJob($controller);
                        break;

                    default:
                        $this->displayHeader();
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
                        $this->displayFooter();
                }
                break;

            default:
                $this->displayHeader();
                $this->displayHomepage();
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
