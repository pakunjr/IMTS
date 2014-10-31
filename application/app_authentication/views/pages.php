<?php

class ViewPages extends ModelPages
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    protected function renderLoginForm ()
    {
        $f = new Form(array(
                'auto_line_break' => true,
                'auto_label' => true
            ));

        $htmlForm = $f->openForm(array(
                'id' => 'login-form',
                'method' => 'post',
                'action' => URL_BASE.'validate_login/',
                'enctype' => 'multipart/form-data'
            )).
        $f->openFieldset(array(
                'legend' => 'Login'
            )).
        '<span class="column">'.
        $f->text(array(
                'id' => 'username',
                'label' => 'Username'
            )).
        $f->password(array(
                'id' => 'password',
                'label' => 'Password'
            )).
        '</span>'.
        $f->closeFieldset().
        $f->submit(array(
                'value' => 'Login'
            )).
        $f->closeForm();

        $htmlIntroduction = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dui enim, tincidunt ut viverra ut, tempus in velit. Donec egestas sollicitudin mauris eu sagittis. In sit amet interdum augue. Vestibulum luctus tellus consectetur quam consectetur vulputate. Phasellus consequat, ante ac pellentesque vehicula, nisl mi imperdiet orci, in maximus magna est a mauris. Quisque aliquam congue lectus, ac elementum lacus porta quis. Aliquam ornare malesuada felis, feugiat sodales purus sagittis quis. Donec in odio mattis, commodo ligula sit amet, suscipit neque. Nunc nunc enim, pretium at tellus non, pellentesque luctus dui. Sed et fermentum ipsum. Donec aliquam tristique velit ut dapibus. Nullam lacinia lectus felis, ac molestie orci aliquet in. Donec vitae euismod diam, id tincidunt elit. Phasellus interdum, odio in tincidunt tristique, lacus mauris condimentum orci, a tincidunt ipsum dolor et purus.</p>
        <p>Vivamus faucibus eros urna, in ullamcorper nisi porta id. In rutrum diam ut arcu rhoncus lobortis. Vivamus id ligula id purus sodales interdum nec ut eros. Donec consequat, eros nec finibus tincidunt, orci tortor pulvinar turpis, at vestibulum nisl est in erat. Maecenas lacinia sed nisi a venenatis. Nam faucibus tincidunt varius. Nam sodales, quam ut sodales vestibulum, arcu libero gravida arcu, eu pellentesque ex magna non felis. Nulla interdum nulla lacus, at rhoncus nulla laoreet vitae. Nullam condimentum porttitor eros, tincidunt lobortis purus euismod tristique. Cras ac lectus mattis, pretium augue non, blandit lectus. Cras scelerisque ex at augue lobortis dignissim. Aliquam id purus lacinia turpis consequat blandit nec maximus elit.</p>
        <p>Etiam nec lobortis magna. Mauris in bibendum ante. Aliquam id lorem non nibh posuere cursus sit amet ut ex. Vestibulum facilisis consequat dui, eu sodales ante cursus non. In hac habitasse platea dictumst. Curabitur in augue sit amet neque imperdiet dapibus. Fusce vitae ligula luctus, feugiat risus ac, rutrum tortor. Nulla id velit maximus, semper libero a, consectetur sem. Quisque in magna id nisi pulvinar rhoncus ut eget turpis. Maecenas blandit nisl sit amet turpis sagittis, non congue est commodo. Ut ante magna, laoreet a feugiat quis, dapibus nec magna. Etiam et fringilla mi. Maecenas volutpat vitae urna vitae dapibus. Nam congue ultrices metus eget fringilla.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut in justo hendrerit, pretium dui et, auctor nisl. Vivamus quam lacus, blandit a purus a, aliquam mollis nulla. Fusce viverra dictum mi non fringilla. Proin nisi mi, vehicula quis nunc dictum, tincidunt ullamcorper tellus. Quisque fermentum dui quis enim convallis, eget gravida purus tristique. Duis et malesuada sem.</p>
        <p>Ut non mauris leo. Donec mattis sodales tortor in fermentum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Quisque sodales, libero in sollicitudin finibus, lorem quam scelerisque est, in venenatis purus erat in sem. Curabitur fringilla velit in sem euismod, quis sollicitudin nunc ultricies. Morbi iaculis ante eros. Sed gravida, orci id sagittis pellentesque, diam dolor molestie ligula, vel fringilla purus libero sed sapien. Donec et hendrerit risus. Donec vitae massa sit amet lacus aliquam facilisis eget id tellus. Pellentesque tincidunt aliquam consequat. Quisque vehicula ornare quam in fermentum.</p>';

        $html = '<div id="login-content" style="text-align: left;">
        '.$htmlForm.$htmlIntroduction.'
        </div>';
        return $html;
    }



    public function renderHeader ()
    {
        $html = '<!DOCTYPE html><html><head>
        <title>Authentication</title>
        <link rel="icon" type="image/png" href="'.URL_BASE_IMG.'system_favicon.png" />
        <link rel="stylesheet" type="text/css" href="'.URL_BASE_CSS.'normalize.min.css" />
        <link rel="stylesheet" type="text/css" href="'.URL_BASE_CSS.'stylesheet.css" />
        <style type="text/css">
            html,
            body {
                overflow: hidden;
                background: url("'.URL_BASE_IMG.'etc_background_texture_noise_white_100x100.png") center center repeat scroll #005b7f;
                font-family: Helvetica, Sans-Serif;
                font-size: 0.95em;
                font-weight: 300;
            }

            #main-container {
                display: block;
                margin: 10px;
                padding: 20px 30px;
                overflow: auto;
                border: 2px solid transparent;
                border-radius: 3px;
                background: url("'.URL_BASE_IMG.'etc_background_texture_noise_white_100x100.png") center center repeat scroll #f2f2f2;
                text-align: center;
            }

            .system-banner {
                display: inline-block;
                margin: 0px 0px 10px 0px;
                padding: 10px 20px;
                border: 2px solid transparent;
                border-radius: 3px;
            }
            .system-logo,
            .system-name-short {
                display: inline-block;
            }
            .system-logo {
                width: 50px;
                height: 50px;
                margin: 0px 7px 15px 0px;
                vertical-align: middle;
            }
            .system-name-short {
                font-size: 2.7em;
                vertical-align: middle;
            }
            .system-name {
                display: block;
                margin: 0px 2px 2px 0px;
                font-size: 1.3em;
            }

            form {
                display: inline-block;
                padding: 10px 20px;
                border: 2px solid transparent;
                border-radius: 3px;
                text-align: left;
            }
            form .column {
                display: inline-block;
                margin: 0px 2px 2px 0px;
                text-align: right;
            }
            fieldset {
                display: block;
                margin: 0px 2px 2px 0px;
                border-radius: 3px;
                text-align: left;
            }
            fieldset legend {
                padding: 4px 8px;
                border: 2px solid transparent;
                border-radius: 3px;
                background: rgba(0, 0, 0, 0.75);
                color: #fff;
            }
            label {
                display: inline-block;
                margin: 0px 2px 2px 0px;
                padding: 4px 8px;
                text-align: right;
                vertical-align: middle;
                cursor: pointer;
            }
            input {
                display: inline-block;
                margin: 0px 2px 2px 0px;
                padding: 4px 8px;
                border: 2px solid transparent;
                border-radius: 3px;
                background: rgba(0, 0, 0, 0.05);
                text-align: left;
                vertical-align: middle;
            }
            input:hover {
                background: rgba(0, 0, 0, 0.1);
            }
            input:active {
                background: rgba(0, 0, 0, 0.03);
            }
            input:focus {
                background: rgba(109, 207, 246, 0.25);
            }

            #login-content {
                display: block;
                margin: 0px 2px 5px 0px;
                padding: 8px 13px;
                overflow: hidden;
                border: 2px solid transparent;
                border-radius: 3px;
            }
            #login-form {
                display: inline-block;
                margin: 0px 10px 8px 0px;
                padding: 0px;
                float: left;
            }
        </style>

        <script type="text/javascript" src="'.URL_BASE_JS.'jquery/jquery-1.11.0.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                var $mainContainer = $("#main-container");

                $mainContainer.css({
                    "height": (
                            parseInt($(window).height()) - 
                            (parseInt($mainContainer.css("margin-top")) * 2) - 
                            (parseInt($mainContainer.css("padding-top")) * 2) - 
                            (parseInt($mainContainer.css("border-top-width")) * 2)
                        ) +"px"
                });

                $(window).resize(function () {
                    $mainContainer.css({
                        "height": (
                                parseInt($(window).height()) -
                                (parseInt($mainContainer.css("margin-top")) * 2) -
                                (parseInt($mainContainer.css("padding-top")) * 2) -
                                (parseInt($mainContainer.css("border-top-width")) * 2)
                            ) +"px"
                    });
                });
            });
        </script>
        </head><body>
        <div id="main-container">
        <span class="system-banner">
        <div class="system-logo"><img src="'.URL_BASE_IMG.'system_logo_50x50.png" /></div>
        <div class="system-name-short">'.SYSTEM_NAME_SHORT.'</div><br />
        <div class="system-name">'.SYSTEM_NAME.'</div>
        </span><div class="hr-light"></div>';
        return $html;
    }



    public function renderFooter ()
    {
        $html = '</div><!-- #main-container -->
        </body></html>';
        return $html;
    }

}
