<?php

$bootstrap_file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'bootstrap.php';
if (file_exists($bootstrap_file)) require_once($bootstrap_file);
else {
    echo 'Fatal Error: Your bootstrap file is missing.';
    exit();
}

//Render the page
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$_SESSION['url'] = $url;

$m_pages = new model_pages();
$c_pages = new controller_pages($m_pages);
$c_pages->renderPages();