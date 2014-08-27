<?php

class view_pages {

    public function renderNavigation ($type='default', $cModel=null) {

        $class = ' class="current-model"';

        $classHome = $cModel == 'home' ? $class : '';
        $classInventory = $cModel == 'inventory' || $cModel == 'inventory_packages' ? $class : '';
        $classPerson = $cModel == 'persons' || $cModel == 'employees' || $cModel == 'owners' ? $class : '';
        $classDepartment = $cModel == 'departments' || $cModel == 'owners' ? $class : '';
        $classAdmin = $cModel == 'admin' ? $class : '';
        $classMyAccount = $cModel == 'my_account' ? $class : '';

        switch ($type) {
            case 'inventory':
                $output = '<ul class="sub-menu">'
                    .'<li><a href="'.URL_BASE.'inventory/create_item/">New Item</a></li>'
                    .'</ul>';
                break;

            case 'person':
                $output = '<ul class="sub-menu">'
                    .'<li><a href="'.URL_BASE.'persons/create_person/">New Person</a></li>'
                    .'</ul>';
                break;

            case 'department':
                $output = '<ul class="sub-menu">'
                    .'<li><a href="'.URL_BASE.'departments/create_department/">New Department</a></li>'
                    .'</ul>';
                break;

            case 'admin':
                $output = '<ul class="sub-menu">'
                    .'<li><a href="'.URL_BASE.'admin/log/errors/">Error/s &amp; Exception/s Log</a></li>'
                    .'</ul>';
                break;

            case 'myAccount':
                $output = '<ul class="sub-menu">'
                    .'<li><a href="#updateProfile">Update Profile</a></li>'
                    .'<li><a href="#changePassword">Change Password</a></li>'
                    .'</ul>';
                break;

            default:
                $output = '<ul id="main-navigation">'
                    .'<li>'.$this->renderNavigation('admin').'<a'.$classAdmin.' href="'.URL_BASE.'admin/">Admin</a></li>'
                    .'<li><a'.$classHome.' href="'.URL_BASE.'">Home</a></li>'
                    .'<li>'.$this->renderNavigation('inventory').'<a'.$classInventory.' href="'.URL_BASE.'inventory/">Inventory</a></li>'
                    .'<li>'.$this->renderNavigation('person').'<a'.$classPerson.' href="'.URL_BASE.'persons/">Person</a></li>'
                    .'<li>'.$this->renderNavigation('department').'<a'.$classDepartment.' href="'.URL_BASE.'departments/">Department</a></li>'
                    .'<li>'.$this->renderNavigation('myAccount').'<a'.$classMyAccount.' href="#myAccount">My Account</a></li>'
                    .'</ul>';
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
                $output .= 'User Error: You are accessing a missing page or a missing file.<br />The page or file you are accessing might have been moved or have been deleted.';
                break;

            case '403':
                $output .= 'User Error: You are unauthorized to access this page.<br />Please login.';
                break;

            default:
                $output .= 'Unknown Error: You have encountered an unknown error, please try again.';
        }
        $output .= '</div>';
        return $output;
    }

}
