<!DOCTYPE html><html><head>

<title>System Portal</title>
<link rel="icon" type="image/png" href="<?php echo URL_BASE_IMG,'system_favicon.png'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE_CSS,'normalize.min.css'; ?>" />
<style type="text/css">
    html,
    body {
        background: url('<?php echo URL_BASE_IMG,"system_background_redirect.jpg"; ?>') center center no-repeat fixed #005b7f;
        font-size: 1em;
        font-weight: 300;
        text-align: center;
    }

    #container {
        display: inline-block;
        margin: 30px;
        padding: 15px 18px;
        border: 2px solid transparent;
        border-radius: 3px;
        background: #f2f2f2;
        text-align: left;
    }

    .hr-light,
    .hr-heavy,
    .hr {
        display: block;
        height: 1px;
        margin: 7px 0px 10px 0px;
        background: #333;
    }
    .hr {
        height: 2px;
    }
    .hr-heavy {
        height: 3px;
    }

    .typo-type-1 {
        font-size: 1.5em;
        font-weight: 800;
    }
    .typo-type-2 {
        font-size: 1.3em;
        font-weight: 600;
    }
    .typo-type-3 {
        font-size: 1.15em;
        font-weight: 500;
    }
    .typo-type-4 {
        font-size: 1em;
        font-weight: 400;
    }
    .typo-type-5 {
        font-size: 0.85em;
        font-weight: 300;
    }
    .typo-type-6 {
        font-size: 0.75em;
        font-weight: 300;
    }

    .button {
        display: inline-block;
        padding: 5px 8px;
        border: 2px solid transparent;
        border-radius: 3px;
        background: rgba(0, 0, 0, 0.08);
        color: #333;
    }
    .button:hover {
        background: rgba(0, 0, 0, 0.15);
    }
    .button:active {
        background: rgba(0, 0, 0, 0.25);
    }
</style>

<script type="text/javascript" src="<?php echo URL_BASE_JS; ?>jquery/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
var redirectUrl = '<?php echo $url; ?>';

var fnLayout = function () {
    var $container = $('#container');
    $container.css({
        'margin-top': parseInt($(window).height()) / 2 - (
                parseInt($container.height()) / 2
            ) +
            'px'
    });
};

var fnCountdownTimer = function () {
    var $timer = $('#timer-countdown'),
        $stopper = $('#timer-countdown-btn-stop'),
        timerCount = 5;
    $timer.html(timerCount);
    var countdownTimer = setInterval(function () {
        if (timerCount === 0) {
            window.location = '<?php echo $url; ?>';
            clearInterval(countdownTimer);
        } else {
            $timer.html(timerCount);
            timerCount--;
        }
    }, 1000);

    $stopper.click(function () {
        clearInterval(countdownTimer);
        $stopper.
            unbind('click').
            val('Click here to redirect.').
            click(function () {
                window.location = redirectUrl;
            });
    });
};

$(document).ready(function () {
    fnLayout();
    fnCountdownTimer();

    $(document).on('keyup', function (event) {
        var keyId = parseInt(event.which);
        if (keyId === 13) {
            window.location = redirectUrl;
        }
    });

    $(window).resize(function () {
        fnLayout();
    });
});
</script>

</head><body>

<div id="container">
    <div style="text-align: center;">
        <img src="<?php echo URL_BASE_IMG,'system_logo_portal_50x50.png'; ?>" style="display: inline-block; width: 50px; height: 50px; margin: 0px 10px 10px 0px; vertical-align: middle;" />
        <div class="typo-type-1" style="display: inline-block; font-weight: 400; vertical-align: middle;">System Portal</div>
        <div class="typo-type-5"><?php echo SYSTEM_NAME; ?></div>
    </div>
    <div class="hr"></div>
    <div><?php echo $message; ?></div>
    <div class="hr-light"></div>
    <div class="typo-type-6">
        You will be automatically redirected in <span id="timer-countdown" class="typo-type-4" style="color: #f00;"></span> seconds.<br />
        Press the <b>Enter</b> key to be redirected immediately.
    </div>
    <div class="hr-light"></div>
    <input id="timer-countdown-btn-stop" class="button" type="button" value="Stop Countdown" />
</div>

</body></html>
