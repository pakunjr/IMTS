<?php

$s['SYSTEM_NAME'] = 'Inventory Monitoring and Tracking System';
$s['SYSTEM_NAME_SHORT'] = 'IMTS';
$s['SYSTEM_VERSION'] = '1.0';
$s['SYSTEM_AUTHOR'] = 'PakunJr';
$s['SYSTEM_TEMPLATE'] = 'default';

$s['URL_BASE'] = 'http://'.$_SERVER['HTTP_HOST'].'/IMTS/';
$s['URL_TEMPLATE'] = $s['URL_BASE'].'public/templates/'.$s['SYSTEM_TEMPLATE'].'/';

$s['DATABASE_HOST'] = '127.0.0.1';
$s['DATABASE_USERNAME'] = 'root';
$s['DATABASE_PASSWORD'] = 'sysdev09';
$s['DATABASE_NAME'] = 'db_imts';
$s['DATABASE_PORT'] = '3306';
$s['DATABASE_SOCKET'] = '';

foreach ($s as $n => $v) {
    defined($n) or define($n, $v);
}
