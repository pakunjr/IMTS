<?php

class view_pages {

    public function __construct () {

    }



    public function __destruct () {

    }



    public function renderNavigation ($type='default', $cModel=null) {
        $fx = new myFunctions();

        $class = ' class="current-model"';

        $classHome = $cModel == 'home'
            ? $class
            : '';
        $classTrack = $cModel == 'track'
            ? $class
            : '';
        $classInventory = in_array($cModel, array('inventory', 'inventory_packages', 'inventory_maintenance'))
            ? $class
            : '';
        $classOwners = in_array($cModel, array('persons', 'employees', 'owners', 'departments'))
            ? $class
            : '';
        $classAdmin = $cModel == 'admin'
            ? $class
            : '';
        $classMyAccount = in_array($cModel, array('my_account', 'accounts'))
            ? $class
            : '';
        $classTickets = in_array($cModel, array('tickets'))
            ? $class
            : '';

        $user_personId = isset($_SESSION['user'])
            ? $_SESSION['user']['personId']
            : null;
        $user_accountId = isset($_SESSION['user'])
            ? $_SESSION['user']['accountId']
            : null;
        $user_accessLevel = isset($_SESSION['user'])
            ? $_SESSION['user']['accessLevel']
            : null;

        switch ($type) {
            case 'inventory':
                $itemNew = $fx->isAccessible('Content Provider')
                    ? '<li><a href="'.URL_BASE.'inventory/create_item/">Item > New</a></li>'
                    : '';
                $packageNew = $fx->isAccessible('Content Provider')
                    ? '<li><a href="'.URL_BASE.'inventory_packages/create_package/">Packages > New</a></li>'
                    : '';
                $maintenanceNew = $fx->isAccessible('Content Provider')
                    ? '<li><a href="'.URL_BASE.'inventory_maintenance/create_maintenance/">Item > Maintenance > New</a></li>'
                    : '';

                $output = '<ul class="sub-menu">
                    '.$itemNew.'
                    <li><a href="'.URL_BASE.'inventory/search_item/">Item > Search</a></li>
                    '.$maintenanceNew.'
                    <li><a href="'.URL_BASE.'inventory_maintenance/search_maintenance/">Item > Maintenance > Search</a></li>
                    '.$packageNew.'
                    <li><a href="'.URL_BASE.'inventory_packages/search_package/">Packages > Search</a></li>
                    </ul>';
                break;

            case 'owners':
                $personNew = $fx->isAccessible('Content Provider')
                    ? '<li><a href="'.URL_BASE.'persons/create_person/">Person > New</a></li>'
                    : '';
                $departmentNew = $fx->isAccessible('Content Provider')
                    ? '<li><a href="'.URL_BASE.'departments/create_department/">Department > New</a></li>'
                    : '';
                $jobNew = $fx->isAccessible('Supervisor')
                    ? '<li><a href="'.URL_BASE.'employees/create_job/">Employment > Job > Create</a></li>'
                    : '';
                $jobSearch = $fx->isAccessible('Supervisor')
                    ? '<li><a href="'.URL_BASE.'employees/search_job/">Employment > Job > Search</a></li>'
                    : '';

                $output = '<ul class="sub-menu">
                    '.$personNew.'
                    <li><a href="'.URL_BASE.'persons/search_person/">Person > Search</a></li>
                    '.$departmentNew.'
                    <li><a href="'.URL_BASE.'departments/search_department/">Department > Search</a></li>
                    '.$jobNew.'
                    '.$jobSearch.'
                    </ul>';
                break;

            case 'admin':
                $output = '<ul class="sub-menu">
                    <li><a href="'.URL_BASE.'admin/phpinfo/">PHP Info</a></li>
                    <li><a href="'.URL_BASE.'admin/log/errors/">Error/s &amp; Exception/s Log</a></li>
                    <li><a href="'.URL_BASE.'admin/log/database_errors/">Database Exceptions and Errors</a></li>
                    </ul>';
                break;

            case 'myAccount':
                $output = '<ul class="sub-menu">
                    <li><a href="'.URL_BASE.'persons/update_person/'.$user_personId.'/">Update Profile</a></li>
                    <li><a href="'.URL_BASE.'accounts/update_password/'.$user_accountId.'/">Change Password</a></li>
                    <li><a href="'.URL_BASE.'accounts/logout/">Logout</a></li>
                    </ul>';
                break;

            case 'tickets':
                $output = '<ul class="sub-menu">
                    <li><a href="'.URL_BASE.'tickets/new_ticket/">Ticket > New</a></li>
                    <li><a href="#">Ticket > Search</a></li>
                    </ul>';
                break;

            case 'tracking':
                $output = '<ul class="sub-menu">
                    <li><a href="'.URL_BASE.'track/owner/">Owner</a></li>
                    <li><a href="'.URL_BASE.'track/">Item</a></li>
                    </ul>';
                break;

            default:
                $blockAdmin = isset($_SESSION['user'])
                        && $fx->isAccessible('Administrator')
                    ? '<li>'.$this->renderNavigation('admin').'<a'.$classAdmin.' href="'.URL_BASE.'admin/">Admin</a></li>'
                    : '';
                $blockTrack = !isset($_SESSION['user'])
                    ? '<li>'.$this->renderNavigation('tracking').'<a'.$classTrack.' href="'.URL_BASE.'track/owner/">Track</a></li>'
                    : '';
                $blockInventory = isset($_SESSION['user'])
                    ? '<li>'.$this->renderNavigation('inventory').'<a'.$classInventory.' href="'.URL_BASE.'inventory/">Inventory</a></li>'
                    : '';
                $blockOwners = isset($_SESSION['user'])
                    ? '<li>'.$this->renderNavigation('owners').'<a'.$classOwners.' href="#">Owners</a></li>'
                    : '';
                $blockTickets = isset($_SESSION['user'])
                    ? '<li>'.$this->renderNavigation('tickets').'<a'.$classTickets.' href="#Tickets">Tickets</a></li>'
                    : '';
                $blockMyAccount = isset($_SESSION['user'])
                    ? '<li>'.$this->renderNavigation('myAccount').'<a'.$classMyAccount.' href="'.URL_BASE.'accounts/read_account/'.$user_accountId.'/">My Account</a></li>'
                    : '';

                $output = '<ul id="main-navigation">
                    '.$blockAdmin.'
                    <li><a'.$classHome.' href="'.URL_BASE.'">Home</a></li>
                    '.$blockTrack.'
                    '.$blockInventory.'
                    '.$blockOwners.'
                    '.$blockTickets.'
                    '.$blockMyAccount.'
                    </ul>';
        }

        $output = $fx->minifyString($output);
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
        $breadcrumb = preg_replace('/_/', ' ', $breadcrumb);

        $output = '<div id="breadcrumb">
            <span id="breadcrumb-clock">Today is '.$fx->dateToWords(date('Y-m-d')).' @<span id="breadcrumb-clock-timer">
            <span id="breadcrumb-clock-timer-hours">'.date('H').'</span>:
            <span id="breadcrumb-clock-timer-minutes">'.date('i').'</span>:
            <span id="breadcrumb-clock-timer-seconds">'.date('s').'</span>
            </span></span>
            <div id="breadcrumb-breadcrumb">'.$breadcrumb.'</div>
            </div>';

        $output = $fx->minifyString($output);
        return $output;
    }



    public function renderPageError ($type='unknown', $customErrorMsg='') {
        $fileHeader = DIR_TEMPLATE.DS.'header.php';
        $fileFooter = DIR_TEMPLATE.DS.'footer.php';

        $fx = new myFunctions();

        ob_start();

        if (file_exists($fileHeader))
            require_once($fileHeader);
        else
            echo '<!-- THEME ERROR: Header, header.php file is missing. -->';

        switch ($type) {
            case '404':
                echo '<div class="error-404"></div>';
                break;

            case '403':
                echo '<div class="error-403"></div>';
                break;

            case 'underconstruction':
            case 'maintenance':
                echo '<div class="error-maintenance"></div>';
                break;

            case 'custom':
                echo $customErrorMsg;
                break;

            default:
                echo 'Unknown Error: You have encountered an unknown error, please try again.';
        }

        if (file_exists($fileFooter))
            require_once($fileFooter);
        else
            echo '<!-- THEME ERROR: Footer, footer.php file is missing. -->';

        $contents = ob_get_clean();
        $contents = $fx->minifyString($contents);
        return $contents;
    }

}
