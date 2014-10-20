<!DOCTYPE html><html><head>

<title><?php echo SYSTEM_NAME,' | ',SYSTEM_AUTHOR; ?></title>

<link rel="shortcut icon" type="image/png" href="<?php echo URL_BASE; ?>public/img/favicon.png" />

<?php
$jQueryStylesheets = array(
    'jquery/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');

foreach ($jQueryStylesheets as $filename) {
    $filepath = DIR_PLUGINS.DS.str_replace('/', DS, $filename);
    if (file_exists($filepath))
        echo '<link rel="stylesheet" type="text/css" href="',URL_BASE,'library/plugins/',$filename,'" />',PHP_EOL;
    else
        echo '<!-- CSS jQuery FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

// Public css
$cssSystemFilePath = array(
    'stylesheet.css');

foreach ($cssSystemFilePath as $filename) {
    $filepath = DIR_PUBLIC.DS.'css'.DS.$filename;
    if (file_exists($filepath))
        echo '<link rel="stylesheet" type="text/css" href="',URL_BASE,'public/css/',$filename,'" />',PHP_EOL;
    else
        echo '<!-- CSS PUBLIC FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

// Template CSS
$cssTemplateFilepath = DIR_TEMPLATE.DS.'stylesheet.css';

if (file_exists($cssTemplateFilepath)) {
    echo '<link rel="stylesheet" type="text/css" href="',URL_TEMPLATE,'stylesheet.css" />';
} else {
    echo '<!-- CSS TEMPLATE FILE MISSING: ',$cssTemplateFilepath,' -->';
}



$jQueryJavascript = array(
    'jquery/jquery-1.11.0.min.js'
    ,'jquery/jquery-alphanumeric.js'
    ,'jquery/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js');

foreach ($jQueryJavascript as $filename) {
    $filepath = DIR_PLUGINS.DS.str_replace('/', DS, $filename);

    if (file_exists($filepath)) {
        echo '<script type="text/javascript" src="',URL_BASE,'library/plugins/',$filename,'"></script>',PHP_EOL;
    } else {
        echo '<!-- JS jQuery FILE MISSING: ',$filepath,' -->',PHP_EOL;
    }
}

// Public javascripts
if (ENVIRONMENT == 'DEVELOPMENT') {
    $systemJavascript = array(
        'javascript.js');
} else {
    $systemJavascript = array(
        'systemJavascript.min.js');
}

foreach ($systemJavascript as $filename) {
    $filepath = DIR_PUBLIC.DS.'js'.DS.$filename;
    if (file_exists($filepath))
        echo '<script type="text/javascript" src="',URL_BASE,'public/js/',$filename,'"></script>',PHP_EOL;
    else
        echo '<!-- JS PUBLIC FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

// Template Javascript
$jsTemplateFilepath = DIR_TEMPLATE.DS.'javascript.js';

if (file_exists($jsTemplateFilepath)) {
    echo '<script type="text/javascript" src="',URL_TEMPLATE,'javascript.js"></script>';
} else {
    echo '<!-- JS TEMPLATE FILE MISSING: ',$jsTemplateFilepath,' -->';
}

?>

</head><body>

<div id="main-content">

<div id="header">
    <?php
    $c_accounts = new controller_accounts();
    $c_accounts->displayLoginForm();

    echo '<div id="header-system-logo"></div>
        <div id="header-system-name-short">',SYSTEM_NAME_SHORT,'</div>
        <div id="header-system-name">',SYSTEM_NAME,'</div>';
    ?>
</div>

<?php
$c_pages = new controller_pages();
$c_pages->displayBreadcrumb();
$c_pages->displaynavigation();
?>

<div class="hr-heavy"></div><br />
<div id="page">
