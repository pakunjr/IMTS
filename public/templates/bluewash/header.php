<!DOCTYPE html><html><head>

<title><?php echo SYSTEM_NAME; ?></title>

<link rel="icon" type="image/png" href="<?php echo URL_BASE_IMG,'system_favicon.png'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE_CSS,'normalize.min.css'; ?>" />
<link rel="styelsheet" type="text/css" href="<?php echo URL_BASE_JS,'jquery/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE_CSS,'stylesheet.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_TEMPLATE,'stylesheet.css'; ?>" />

<script type="text/javascript" src="<?php echo URL_BASE_JS,'jquery/jquery-1.11.0.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo URL_BASE_JS,'javascript.js'; ?>"></script>
<script type="text/javascript" src="<?php echo URL_TEMPLATE,'javascript.js'; ?>"></script>

</head><body>
<div id="system-header">
    <div id="user-information">
    <?php

    $userJobs = '';
    if (!empty($_SESSION['user']['jobs'])) {
        foreach ($_SESSION['user']['jobs'] as $job) {
            $userJobs .= $job.', ';
        }
        $userJobs = trim($userJobs, ', ');
    }

    $userDepartments = '';
    if (!empty($_SESSION['user']['departments'])) {
        foreach ($_SESSION['user']['departments'] as $department) {
            $userDepartments .= $department.', ';
        }
        $userDepartments = trim($userDepartments, ', ');
    }

    if ($_SESSION['user']['accessLevel'] == 'Administrator') {
        $adminLinks = '<a title="View Logs" href="'.URL_BASE.'user_settings/logs/">View Logs</a>';
    } else {
        $adminLinks = '';
    }

    $html = '<div>
    <div>
        <span id="user-information-settings">
        <img class="box20x20" src="'.URL_BASE_IMG.'system_icon_gear.png" style="display: inline-block; margin: 0px 5px 2px 0px; vertical-align: middle;" />
            <div id="user-information-settings-options">
            <a title="Edit your user profile or account details" href="'.URL_BASE.'user_settings/profile/update_profile/">Update your Profile</a>
            <a title="Edit your user profile or account details" href="'.URL_BASE.'user_settings/profile/change_password/">Change your Password</a>
            '.$adminLinks.'
            <a title="Logout from the System" href="'.URL_BASE.'logout/">Logout</a>
            </div>
        </span>
        '.$_SESSION['user']['user'].' ('.$_SESSION['user']['username'].')
    </div>
    <div>
    <a id="user-information-logout" title="Logout from the System" href="'.URL_BASE.'logout/"><img style="display: block;" src="'.URL_BASE_IMG.'system_icon_logout.png" /></a>
    <div class="typo-type-5">'.$userDepartments.'</div>
    <div class="typo-type-6">'.$userJobs.'</div>
    </div>
    </div>';
    echo $html;

    ?>
    </div>
    <a title="IMTTS Homepage" href="<?php echo URL_BASE; ?>">
        <img class="box30x30" style="margin: 0px 7px 5px 0px; vertical-align: middle;" src="<?php echo URL_BASE_IMG,'system_logo_50x50.png'; ?>" />
        <span class="typo-type-1" style="vertical-align: middle;"><?php echo SYSTEM_NAME_SHORT; ?></span><br />
        <span class="typo-type-4"><?php echo SYSTEM_NAME; ?></span>
    </a>
</div><!-- #system-header -->
<div id="system-body">
<div id="system-contents">
