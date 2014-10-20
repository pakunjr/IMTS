<?php

$bootstrap_file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'system_core'.DIRECTORY_SEPARATOR.'bootstrap.php';

if (file_exists($bootstrap_file)) {
    require_once($bootstrap_file);
} else {
    exit('Fatal Error: Your bootstrap file is missing.<br />Exiting...');
}

// Render the URL
if (!empty($_GET['url'])) {
    $url = $_GET['url'].'/';
    $url = preg_replace('/(\/\/+)/', '/', $url);
} else {
    $url = 'home/';
}

define('URL_REQUEST', $url);

// Render the page routing
$cPages = new ControllerPages();
$cPages->routePage();