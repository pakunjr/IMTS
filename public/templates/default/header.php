<!DOCTYPE html><html><head>

<title><?php echo SYSTEM_NAME,' | ',SYSTEM_AUTHOR; ?></title>

<link rel="shortcut icon" type="image/png" href="<?php echo URL_BASE; ?>public/img/favicon.png" />

<?php
$css_jquery = array(
    'jquery/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
foreach ($css_jquery as $filename) {
    $filepath = DIR_PLUGINS.DS.str_replace('/', DS, $filename);
    if (file_exists($filepath))
        echo '<link rel="stylesheet" type="text/css" href="',URL_BASE,'library/plugins/',$filename,'" />',PHP_EOL;
    else echo '<!-- CSS jQuery FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

//Public css
$css_public = array(
    'errors.css');
foreach ($css_public as $filename) {
    $filepath = DIR_PUBLIC.DS.'css'.DS.$filename;
    if (file_exists($filepath))
        echo '<link rel="stylesheet" type="text/css" href="',URL_BASE,'public/css/',$filename,'" />',PHP_EOL;
    else echo '<!-- CSS PUBLIC FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

//Template css
if (ENVIRONMENT == 'DEVELOPMENT') {
    $css_template = array(
        'layout.css'
        ,'layout_navigation.css'
        ,'typography.css'
        ,'breadcrumb.css'
        ,'datepicker.css'
        ,'forms.css'
        ,'tables.css');
    foreach ($css_template as $filename) {
        $filepath = DIR_TEMPLATE.DS.'css'.DS.$filename;
        if (file_exists($filepath))
            echo '<link rel="stylesheet" type="text/css" href="',URL_TEMPLATE,'css/',$filename,'" />',PHP_EOL;
        else echo '<!-- CSS TEMPLATE FILE MISSING: ',$filepath,' -->',PHP_EOL;
    }
} else if (ENVIRONMENT == 'PRODUCTION') {
    $filepath = DIR_TEMPLATE.DS.'css'.DS.'minified.css';
    if (file_exists($filepath))
        echo '<link rel="stylesheet" type="text/css" href="',URL_TEMPLATE,'css/minified.css" />',PHP_EOL;
    else echo '<!-- minified.css FROM TEMPLATE CSS IS MISSING -->',PHP_EOL;
} else echo '<!-- UNRECOGNIZED SYSTEM ENVIRONMENT, CAN NOT DEPLOY TEMPLATE CSS FILES -->',PHP_EOL;

echo PHP_EOL;

$js_jquery = array(
    'jquery/jquery-1.11.0.min.js'
    ,'jquery/jquery-alphanumeric.js'
    ,'jquery/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js');
foreach ($js_jquery as $filename) {
    $filepath = DIR_PLUGINS.DS.str_replace('/', DS, $filename);
    if (file_exists($filepath))
        echo '<script type="text/javascript" src="',URL_BASE,'library/plugins/',$filename,'"></script>',PHP_EOL;
    else echo '<!-- JS jQuery FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

//Public javascripts
if (ENVIRONMENT == 'DEVELOPMENT') {
    $js_public = array(
        'alerts.js'
        ,'script.js'
        ,'accordion.js'
        ,'forms.js');
    foreach ($js_public as $filename) {
        $filepath = DIR_PUBLIC.DS.'js'.DS.$filename;
        if (file_exists($filepath))
            echo '<script type="text/javascript" src="',URL_BASE,'public/js/',$filename,'"></script>',PHP_EOL;
        else echo '<!-- JS PUBLIC FILE MISSING: ',$filepath,' -->',PHP_EOL;
    }
} else if (ENVIRONMENT == 'PRODUCTION') {
    $filepath = DIR_PUBLIC.DS.'js'.DS.'minified.js';
    if (file_exists($filepath))
        echo '<script type="text/javascript" src="',URL_TEMPLATE,'js/minified.js"></script>',PHP_EOL;
    else echo '<!-- minified.js FROM PUBLIC JAVASCRIPTS IS MISSING -->',PHP_EOL;
} else echo '<!-- UNRECOGNIZED SYSTEM ENVIRONMENT, CAN NOT DEPLOY PUBLIC JAVASCRIPT FILES -->',PHP_EOL;

//Template javascripts
if (ENVIRONMENT == 'DEVELOPMENT') {
    $js_template = array(
        'layout.js'
        ,'breadcrumb_timer.js'
        ,'navigation.js'
        ,'items.js'
        ,'owners.js'
        ,'accounts.js'
        ,'employment.js'
        ,'forms.js'
        ,'in_searches.js');
    foreach ($js_template as $filename) {
        $filepath = DIR_TEMPLATE.DS.'js'.DS.$filename;
        if (file_exists($filepath))
            echo '<script type="text/javascript" src="',URL_TEMPLATE,'js/',$filename,'"></script>',PHP_EOL;
        else echo '<!-- JS TEMPLATE FILE MISSING: ',$filepath,' -->',PHP_EOL;
    }
} else if (ENVIRONMENT == 'PRODUCTION') {
    $filepath = DIR_TEMPLATE.DS.'js'.DS.'minified.js';
    if (file_exists($filepath))
        echo '<script type="text/javascript" src="',URL_TEMPLATE,'js/minified.js"></script>',PHP_EOL;
    else echo '<!-- minified.js FROM TEMPLATE JAVASCRIPTS IS MISSING -->',PHP_EOL;
} else echo '<!-- UNRECOGNIZED SYSTEM ENVIRONMENT, CAN NOT DEPLOY TEMPLATE JAVASCRIPT FILES -->',PHP_EOL;
?>

</head><body>

<div id="main-content">

<div id="header">
    <?php
    $c_accounts = new controller_accounts();
    $c_accounts->displayLoginForm();

    echo '<div id="header-system-logo"></div>'
        ,'<div id="header-system-name-short">',SYSTEM_NAME_SHORT,'</div>'
        ,'<div id="header-system-name">',SYSTEM_NAME,'</div>';
    ?>
</div>

<?php
$c_pages = new controller_pages();
$c_pages->displayBreadcrumb();
$c_pages->displaynavigation();
?>
