<?php

class view_pages {

    public function renderNavigation ($type='default', $cModel=null) {

        $class = ' class="current-model"';

        $classHome = $cModel == 'home' ? $class : '';
        $classInventory = $cModel == 'inventory' || $cModel == 'inventory_packages' ? $class : '';
        $classOwners = $cModel == 'persons'
            || $cModel == 'employees'
            || $cModel == 'owners'
            || $cModel == 'departments' ? $class : '';
        $classAdmin = $cModel == 'admin' ? $class : '';
        $classMyAccount = $cModel == 'my_account'
            || $cModel == 'accounts' ? $class : '';

        $user_personId = isset($_SESSION['user']) ? $_SESSION['user']['personId'] : '';
        $user_accountId = isset($_SESSION['user']) ? $_SESSION['user']['accountId'] : '';
        $user_accessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : '';

        switch ($type) {
            case 'inventory':
                $output = '<ul class="sub-menu">'
                    .'<li><a href="'.URL_BASE.'inventory/create_item/">Item > New</a></li>'
                    .'<li><a href="'.URL_BASE.'inventory/search_item/">Item > Search</a></li>'
                    .'<li><a href="'.URL_BASE.'inventory_packages/create_package/">Packages > New</a></li>'
                    .'<li><a href="'.URL_BASE.'inventory_packages/search_package/">Packages > Search</a></li>'
                    .'</ul>';
                break;

            case 'owners':
                $output = '<ul class="sub-menu">'
                    .'<li><a href="'.URL_BASE.'persons/create_person/">Person > New</a></li>'
                    .'<li><a href="'.URL_BASE.'persons/search_person/">Person > Search</a></li>'
                    .'<li><a href="'.URL_BASE.'departments/create_department/">Department > New</a></li>'
                    .'<li><a href="'.URL_BASE.'departments/search_department/">Department > Search</a></li>'
                    .'<li><a href="'.URL_BASE.'employees/create_job/">Employment > Job > Create</a></li>'
                    .'<li><a href="'.URL_BASE.'employees/search_job/">Employment > Job > Search</a></li>'
                    .'</ul>';
                break;

            case 'admin':
                $output = '<ul class="sub-menu">'
                    .'<li><a href="'.URL_BASE.'admin/log/errors/">Error/s &amp; Exception/s Log</a></li>'
                    .'</ul>';
                break;

            case 'myAccount':
                $output = '<ul class="sub-menu">'
                    .'<li><a href="'.URL_BASE.'persons/update_person/'.$user_personId.'/">Update Profile</a></li>'
                    .'<li><a href="'.URL_BASE.'accounts/update_password/'.$user_accountId.'/">Change Password</a></li>'
                    .'<li><a href="'.URL_BASE.'accounts/logout/">Logout</a></li>'
                    .'</ul>';
                break;

            default:
                $output = '<ul id="main-navigation">';
                $output .= isset($_SESSION['user'])
                        && ($user_accessLevel == 'Administrator'
                            || $user_accessLevel == 'Admin')
                    ? '<li>'.$this->renderNavigation('admin').'<a'.$classAdmin.' href="'.URL_BASE.'admin/">Admin</a></li>'
                    : '';
                $output .= '<li><a'.$classHome.' href="'.URL_BASE.'">Home</a></li>';
                $output .= !isset($_SESSION['user'])
                    ? '<li><a href="'.URL_BASE.'track/item/">Track Item</a></li>'
                    : '';
                $output .= !isset($_SESSION['user'])
                    ? '<li><a href="'.URL_BASE.'track/owner/">Track Owner</a></li>'
                    : '';
                $output .= isset($_SESSION['user'])
                    ? '<li>'.$this->renderNavigation('inventory').'<a'.$classInventory.' href="'.URL_BASE.'inventory/">Inventory</a></li>'
                    : '';
                $output .= isset($_SESSION['user'])
                    ? '<li>'.$this->renderNavigation('owners').'<a'.$classOwners.' href="#">Owners</a></li>'
                    : '';
                $output .= isset($_SESSION['user'])
                    ? '<li>'.$this->renderNavigation('myAccount').'<a'.$classMyAccount.' href="'.URL_BASE.'accounts/read_account/'.$user_accountId.'/">My Account</a></li>'
                    : '';
                $output .= '</ul>';
        }
        return $output;
    }



    public function renderBreadcrumb ($objModel) {
        $model = $objModel->get('model');
        $view = $objModel->get('view');
        $controller = $objModel->get('controller');
        $action = $objModel->get('action');
        $extra = $objModel->get('extra');

        $fx = new myFunctions();

        $breadcrumb = $model != null ? $model : '';
        $breadcrumb .= $view != null ? ' > '.$view : '';
        $breadcrumb .= $controller != null ? ' > '.$controller : '';
        $breadcrumb .= $action != null ? ' > '.$action : '';
        $breadcrumb .= $extra != null ? ' > '.$extra : '';

        $output = '<div id="breadcrumb">'
            .'<span id="breadcrumb-clock">Today is '.$fx->dateToWords(date('Y-m-d')).' @<span id="breadcrumb-clock-timer">'
            .'<span id="breadcrumb-clock-timer-hours">'.date('H').'</span>:'
            .'<span id="breadcrumb-clock-timer-minutes">'.date('i').'</span>:'
            .'<span id="breadcrumb-clock-timer-seconds">'.date('s').'</span>'
            .'</span></span>'
            .'<div id="breadcrumb-breadcrumb">'.$breadcrumb.'</div>'
            .'</div>';
        return $output;
    }



    public function renderErrorPage ($type='unknown') {
        $output = '<div id="error-page">';
        switch ($type) {
            case '404':
                $output .= '<span style="color: #f00;">Note</span>: You are accessing a missing page or a missing file.<br />The page or file you are accessing might have been moved or have been deleted.';
                break;

            case '403':
                $output .= '<span style="color: #f00;">Note</span>: You are unauthorized to access this page.<br />Either you must login or you need an account with higher access level.';
                break;

            case 'underconstruction':
            case 'maintenance':
                $output .= 'Sorry, this page is underconstruction or maintenance.';
                break;

            default:
                $output .= 'Unknown Error: You have encountered an unknown error, please try again.';
        }
        $output .= '</div>';
        return $output;
    }

}
