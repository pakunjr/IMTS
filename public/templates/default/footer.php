</div><!-- #page -->
<br /><div id="footer">
    <div class="hr-heavy"></div>
    <?php
        $output = '<div id="copyright">'
            .SYSTEM_NAME.' '.SYSTEM_VERSION.'<br />'
            .'Lorma Colleges &copy; '.SYSTEM_YEAR_START.' - '.date('Y')
            .'</div>';
        echo $output;
    ?>
</div>

</div><!-- #main-content -->

<?php

$js_jquery = array(
    'jquery/jquery-1.11.0.min.js'
    ,'jquery/jquery-alphanumeric.js'
    ,'jquery/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js');
foreach ($js_jquery as $filename) {
    $filepath = DIR_PLUGINS.DS.str_replace('/', DS, $filename);
    if (file_exists($filepath))
        echo '<script type="text/javascript" src="',URL_BASE,'library/plugins/',$filename,'"></script>',PHP_EOL;
    else
        echo '<!-- JS jQuery FILE MISSING: ',$filepath,' -->',PHP_EOL;
}

//Public javascripts
if (ENVIRONMENT == 'DEVELOPMENT') {
    $js_public = array(
        'alerts.js'
        ,'script.js'
        ,'accordion.js'
        ,'forms.js'
        ,'pagination.js'
        ,'systemJavascript.js');
    foreach ($js_public as $filename) {
        $filepath = DIR_PUBLIC.DS.'js'.DS.$filename;
        if (file_exists($filepath))
            echo '<script type="text/javascript" src="',URL_BASE,'public/js/',$filename,'"></script>',PHP_EOL;
        else
            echo '<!-- JS PUBLIC FILE MISSING: ',$filepath,' -->',PHP_EOL;
    }
} else if (ENVIRONMENT == 'PRODUCTION') {
    $filepath = DIR_PUBLIC.DS.'js'.DS.'minified.js';
    if (file_exists($filepath))
        echo '<script type="text/javascript" src="',URL_TEMPLATE,'js/minified.js"></script>',PHP_EOL;
    else
        echo '<!-- minified.js FROM PUBLIC JAVASCRIPTS IS MISSING -->',PHP_EOL;
} else
    echo '<!-- UNRECOGNIZED SYSTEM ENVIRONMENT, CAN NOT DEPLOY PUBLIC JAVASCRIPT FILES -->',PHP_EOL;

//Template javascripts
if (ENVIRONMENT == 'DEVELOPMENT') {
    $js_template = array(
        'layout.js'
        ,'breadcrumb_timer.js'
        ,'navigation.js'
        ,'errors.js'
        ,'items.js'
        ,'owners.js'
        ,'accounts.js'
        ,'employment.js'
        ,'department.js'
        ,'forms.js'
        ,'in_searches.js'
        ,'myJavascript.js');
    foreach ($js_template as $filename) {
        $filepath = DIR_TEMPLATE.DS.'js'.DS.$filename;
        if (file_exists($filepath))
            echo '<script type="text/javascript" src="',URL_TEMPLATE,'js/',$filename,'"></script>',PHP_EOL;
        else
            echo '<!-- JS TEMPLATE FILE MISSING: ',$filepath,' -->',PHP_EOL;
    }
} else if (ENVIRONMENT == 'PRODUCTION') {
    $filepath = DIR_TEMPLATE.DS.'js'.DS.'minified.js';
    if (file_exists($filepath))
        echo '<script type="text/javascript" src="',URL_TEMPLATE,'js/minified.js"></script>',PHP_EOL;
    else
        echo '<!-- minified.js FROM TEMPLATE JAVASCRIPTS IS MISSING -->',PHP_EOL;
} else
    echo '<!-- UNRECOGNIZED SYSTEM ENVIRONMENT, CAN NOT DEPLOY TEMPLATE JAVASCRIPT FILES -->',PHP_EOL;

?>

</body></html>