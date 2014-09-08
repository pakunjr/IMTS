<?php session_start(); date_default_timezone_set('Asia/Manila');

define('ENVIRONMENT', 'DEVELOPMENT');
define('DS', DIRECTORY_SEPARATOR);
define('DIR_ROOT', dirname(dirname(__FILE__)));
define('DIR_APPLICATION', DIR_ROOT.DS.'application');
define('DIR_CONTROLLERS', DIR_APPLICATION.DS.'controllers');
define('DIR_MODELS', DIR_APPLICATION.DS.'models');
define('DIR_VIEWS', DIR_APPLICATION.DS.'views');
define('DIR_LIBRARY', DIR_ROOT.DS.'library');
define('DIR_CLASSES', DIR_LIBRARY.DS.'classes');
define('DIR_LOGS', DIR_LIBRARY.DS.'logs');
define('DIR_PLUGINS', DIR_LIBRARY.DS.'plugins');
define('DIR_PUBLIC', DIR_ROOT.DS.'public');
define('DIR_TEMPLATES', DIR_PUBLIC.DS.'templates');

$config_file = DIR_APPLICATION.DS.'config.php';
if (file_exists($config_file)) require_once($config_file);
else {
    echo 'Fatal Error: Your systems configuration file is missing.<br />You have and will encounter fatal errors.';
    exit();
}

define('DIR_TEMPLATE', DIR_TEMPLATES.DS.SYSTEM_TEMPLATE);



//Automagically load classes
function autoloadclasses ($classname) {
    $paths = array(
        DIR_CONTROLLERS.DS.$classname.'.php'
        ,DIR_MODELS.DS.$classname.'.php'
        ,DIR_VIEWS.DS.$classname.'.php'
        ,DIR_CLASSES.DS.$classname.'.php');
    foreach ($paths as $path) {
        if (file_exists($path)) require_once($path);
    }
}
spl_autoload_register('autoloadclasses');
