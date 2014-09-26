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
    else
        echo '<!-- CSS jQuery FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

//Public css
$css_public = array(
    'systemStylesheet.css');
foreach ($css_public as $filename) {
    $filepath = DIR_PUBLIC.DS.'css'.DS.$filename;
    if (file_exists($filepath))
        echo '<link rel="stylesheet" type="text/css" href="',URL_BASE,'public/css/',$filename,'" />',PHP_EOL;
    else
        echo '<!-- CSS PUBLIC FILE MISSING: ',$filepath,' -->',PHP_EOL;
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
        ,'tables.css'
        ,'myStylesheet.css');
    foreach ($css_template as $filename) {
        $filepath = DIR_TEMPLATE.DS.'css'.DS.$filename;
        if (file_exists($filepath))
            echo '<link rel="stylesheet" type="text/css" href="',URL_TEMPLATE,'css/',$filename,'" />',PHP_EOL;
        else
            echo '<!-- CSS TEMPLATE FILE MISSING: ',$filepath,' -->',PHP_EOL;
    }
} else if (ENVIRONMENT == 'PRODUCTION') {
    $filepath = DIR_TEMPLATE.DS.'css'.DS.'minified.css';
    if (file_exists($filepath))
        echo '<link rel="stylesheet" type="text/css" href="',URL_TEMPLATE,'css/minified.css" />',PHP_EOL;
    else
        echo '<!-- minified.css FROM TEMPLATE CSS IS MISSING -->',PHP_EOL;
} else
    echo '<!-- UNRECOGNIZED SYSTEM ENVIRONMENT, CAN NOT DEPLOY TEMPLATE CSS FILES -->',PHP_EOL;

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
