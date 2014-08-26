<!DOCTYPE html><html><head>

<title><?php echo SYSTEM_NAME,' | ',SYSTEM_AUTHOR; ?></title>

<?php
$css_jquery = array(
    'jquery/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
foreach ($css_jquery as $filename) {
    $filepath = DIR_PLUGINS.DS.str_replace('/', DS, $filename);
    if (file_exists($filepath))
        echo '<link rel="stylesheet" type="text/css" href="',URL_BASE,'library/plugins/',$filename,'" />',PHP_EOL;
    else echo '<!-- CSS jQuery FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

$css_public = array();
foreach ($css_public as $filename) {
    $filepath = DIR_PUBLIC.DS.'css'.DS.$filename;
    if (file_exists($filepath))
        echo '<link rel="stylesheet" type="text/css" href="',URL_BASE,'public/css/',$filename,'" />',PHP_EOL;
    else echo '<!-- CSS PUBLIC FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

$css_template = array(
    'layout.css'
    ,'layout_navigation.css'
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

$js_public = array(
    'script.js'
    ,'accordion.js'
    ,'forms.js');
foreach ($js_public as $filename) {
    $filepath = DIR_PUBLIC.DS.'js'.DS.$filename;
    if (file_exists($filepath))
        echo '<script type="text/javascript" src="',URL_BASE,'public/js/',$filename,'"></script>',PHP_EOL;
    else echo '<!-- JS PUBLIC FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

$js_template = array(
    'breadcrumb_timer.js'
    ,'navigation.js'
    ,'items.js'
    ,'owners.js');
foreach ($js_template as $filename) {
    $filepath = DIR_TEMPLATE.DS.'js'.DS.$filename;
    if (file_exists($filepath))
        echo '<script type="text/javascript" src="',URL_TEMPLATE,'js/',$filename,'"></script>',PHP_EOL;
    else echo '<!-- JS TEMPLATE FILE MISSING: ',$filepath,' -->',PHP_EOL;
}
?>

</head><body>

<div id="main-content">

<div id="header">
    <?php echo '<div id="header-system-name-short">',SYSTEM_NAME_SHORT,'</div>'
        ,'<div id="header-system-name">',SYSTEM_NAME,'</div>'; ?>
</div>

<?php
$c_pages = new controller_pages();
$c_pages->displayBreadcrumb();
$c_pages->displaynavigation();
?>
