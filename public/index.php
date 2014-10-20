<?php

// Render and define the URL
if (!empty($_GET['url'])) {
    $url = $_GET['url'].'/';
    $url = preg_replace('/(\/\/+)/', '/', $url);
} else {
    $url = 'home/';
}
define('URL_REQUEST', $url);

$bootstrapFilepath = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'system_core'.DIRECTORY_SEPARATOR.'bootstrap.php';
if (file_exists($bootstrapFilepath)) {
    require_once($bootstrapFilepath);
} else {
    exit('Fatal Error: Your bootstrap file, '.$bootstrapFilepath.', is missing.<br />Exiting...');
}

// Render the page routing
$cPages = new ControllerPages();
$cPages->routePage();