<?php

session_start();
date_default_timezone_set('Asia/Manila');
error_reporting(E_ALL);

// Environment expected values
// DEVELOPMENT: Coding
// PRODUCTION: Deployment
// STAGING: Testing
define('ENVIRONMENT', 'DEVELOPMENT');

// System directories
define('DS', DIRECTORY_SEPARATOR);
define('DIR_ROOT', dirname(dirname(dirname(__FILE__))));
define('DIR_APPLICATIONS', DIR_ROOT.DS.'application');
define('DIR_SYSTEM_CONFIGS', DIR_APPLICATIONS.DS.'system_configs');
define('DIR_SYSTEM_CORE', DIR_APPLICATIONS.DS.'system_core');

// System configuration files
$configFiles = array(
        'database',
        'system',
        'url'
    );
foreach ($configFiles as $filename) {
    $filepath = DIR_SYSTEM_CONFIGS.DS.$filename.'.php';
    if (file_exists($filepath)) {
        require_once($filepath);
    } else {
        exit('Fatal Error: One of your configuration files, <b>'.$filepath.'</b>, is missing.');
    }
}

// Application directories
if (empty($_SESSION['user'])) {
    $appType = 'app_authentication';
} else {
    $userDepartments = $_SESSION['user']['departments'];
    $userJobs = $_SESSION['user']['jobs'];
    $userAccessLevel = $_SESSION['user']['accessLevel'];
    $url = explode('/', URL_REQUEST);

    // Conditions
    $cond = array(
            'HRMO' => in_array(
                    'Human Resource Management Office',
                    $userDepartments
                ),
            'ITS' => in_array('IT Services', $userDepartments),
            'PS' => in_array(
                    'Properties and Supplies',
                    $userDepartments
                ),
            'System' => in_array('System Administrator', $userJobs) ||
                in_array('System Developer', $userJobs)
        );

    if ($url[0] === 'logout') {
        if (!empty($_SESSION['user'])) {
            session_destroy();
        }
        header('location: '.URL_BASE);
        exit();
    } else if ($url[0] === 'user_settings') {
        $appType = 'app_users';
    } else {
        if ($cond['HRMO']) {
            $appType = 'app_employees';
        } else if ($cond['ITS']) {
            if ($cond['System']) {
                $appType = 'app_administrators';
            } else {
                if ($url[0] === 'ticket') {
                    $appType = 'app_ticketing';
                } else {
                    $appType = 'app_ownership';
                }
            }
        } else if ($cond['PS']) {
            $appType = 'app_inventory';
        } else {
            $appType = 'app_unknown';
        }
    }
}
define('DIR_APPLICATION', DIR_APPLICATIONS.DS.$appType);
define('DIR_CONTROLLERS', DIR_APPLICATION.DS.'controllers');
define('DIR_MODELS', DIR_APPLICATION.DS.'models');
define('DIR_VIEWS', DIR_APPLICATION.DS.'views');

// Library directories
define('DIR_LIBRARY', DIR_ROOT.DS.'library');
define('DIR_FONTS', DIR_LIBRARY.DS.'fonts');
define('DIR_LOGS', DIR_LIBRARY.DS.'logs');
define('DIR_PLUGINS', DIR_LIBRARY.DS.'plugins');

// Public directories
define('DIR_PUBLIC', DIR_ROOT.DS.'public');
define('DIR_CSS', DIR_PUBLIC.DS.'css');
define('DIR_IMG', DIR_PUBLIC.DS.'img');
define('DIR_JS', DIR_PUBLIC.DS.'js');
define('DIR_TEMPLATES', DIR_PUBLIC.DS.'templates');
define('DIR_TEMPLATE', DIR_TEMPLATES.DS.SYSTEM_TEMPLATE);

$coreFile = DIR_SYSTEM_CORE.DS.'core.php';
if (file_exists($coreFile)) {
    require_once($coreFile);
} else {
    exit('Fatal Error: Your core file, '.$coreFile.', is missing.<br />Please contact your System Administrators to fix this error.<br />Exiting...');
}

// Autoload classes
spl_autoload_register(function ($classname) {
    if (!class_exists($classname)) {
        $pattern = '/(Controller|Model|View)/';
        if (preg_match($pattern, $classname) === 1) {
            $filename = preg_replace($pattern, '', $classname);
            $filename = lcfirst($filename);
            $paths = array(
                    DIR_CONTROLLERS.DS.$filename.'.php',
                    DIR_MODELS.DS.$filename.'.php',
                    DIR_VIEWS.DS.$filename.'.php'
                );
        } else {
            $filename = lcfirst($classname);
            $paths = array(
                    DIR_SYSTEM_CORE.DS.'core_'.$filename.'.php'
                );
        }

        foreach ($paths as $path) {
            if (file_exists($path)) {
                require_once($path);
            }
        }

        if (!class_exists($classname)) {
            $core = new SystemCore();
            $log = new Log();
            $log->createLog('The Class, '.$classname.', failed to be autoloaded by the system.<br />
                The system execution has been terminated.<br /><br />'.
                $core->checkPaths($paths),
                'Critical');
            exit('Fatal Error: Class , '.$classname.', is missing.<br /><a href="'.URL_BASE.'">Click here</a> to go back to the Homepage.<br />Exiting...');
        }
    }
});
