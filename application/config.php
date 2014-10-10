<?php

$configs['SYSTEM_NAME'] = 'Inventory Monitoring and Tracking System';
$configs['SYSTEM_NAME_SHORT'] = 'IMTS';
$configs['SYSTEM_VERSION'] = '1.0';
$configs['SYSTEM_AUTHOR'] = 'PakunJr';
$configs['SYSTEM_TEMPLATE'] = 'default';
$configs['SYSTEM_YEAR_START'] = '2014';

if ($_SERVER['HTTP_HOST'] == 'localhost')
    $configs['URL_BASE'] = 'http://'.$_SERVER['HTTP_HOST'].'/IMTS/';
else
    $configs['URL_BASE'] = 'http://'.$_SERVER['HTTP_HOST'].'/';
$configs['URL_TEMPLATE'] = $configs['URL_BASE'].'public/templates/'.$configs['SYSTEM_TEMPLATE'].'/';

// Default configuration of the database
// which is the IMTS database server
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $configs['DATABASE_HOST'] = '127.0.0.1';
    $configs['DATABASE_USERNAME'] = 'root';
    $configs['DATABASE_PASSWORD'] = 'sysdev09';
    $configs['DATABASE_NAME'] = 'db_imts';
    $configs['DATABASE_PORT'] = '3306';
    $configs['DATABASE_SOCKET'] = '';
} else {
    // This config is the default for the server
    $configs['DATABASE_HOST'] = '127.0.0.1';
    $configs['DATABASE_USERNAME'] = 'eqmtsdb';
    $configs['DATABASE_PASSWORD'] = 'UYT436DSFGFlqywp';
    $configs['DATABASE_NAME'] = 'eqmts';
    $configs['DATABASE_PORT'] = '3306';
    $configs['DATABASE_SOCKET'] = '';
}

// Other database server configurations
$databaseConfigs = array(
    'ticket' => array(
        'host' => 'localhost'
        ,'username' => 'root'
        ,'password' => 'sysdev09'
        ,'database' => 'db_imts_ticket'));
defined('DATABASE_SERVERS') or define('DATABASE_SERVERS', serialize($databaseConfigs));

foreach ($configs as $name => $value) {
    defined($name) or define($name, $value);
}
