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



    public function renderLoginForm ()
    {
        $f = new Form(array(
                'auto_line_break' => true,
                'auto_label' => true
            ));
        $html = $f->openForm(array(
                'id' => '',
                'method' => 'post',
                'action' => URL_BASE.'validate_login/',
                'enctype' => 'multipart/form-data'
            )).
        $f->openFieldset(array(
                'legend' => 'Login'
            )).
        $f->text(array(
                'id' => 'username',
                'label' => 'Username'
            )).
        $f->password(array(
                'id' => 'password',
                'label' => 'Password'
            )).
        $f->closeFieldset().
        $f->submit(array(
                'value' => 'Login'
            )).
        $f->closeForm();
        return $html;
    }



    public function renderHeader ()
    {
        $html = '<!DOCTYPE html><html><head>
        <title>Authentication</title>
        <link rel="stylesheet" type="text/css" href="'.URL_BASE_CSS.'normalize.min.css" />
        <link rel="icon" type="image/png" href="'.URL_BASE_IMG.'system_favicon.png" />
        <style type="text/css">
            html,
            body {
                overflow: hidden;
                background: url(\''.URL_BASE_IMG.'system_authentication_background.jpg\') center center no-repeat scroll #000b14;
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
                background: rgba(255, 255, 255, 0.75);
                text-align: center;
            }

            .system-banner {
                display: inline-block;
                margin: 0px 0px 30px 0px;
                padding: 10px 20px;
                border: 2px solid transparent;
                border-radius: 3px;
                background: rgba(255, 255, 255, 0.75);
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
                background: rgba(255, 255, 255, 0.85);
                text-align: left;
            }
            fieldset {
                display: block;
                margin: 0px 2px 2px 0px;
                border-radius: 3px;
                background: #fff;
                text-align: right;
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
        </style>

        <script type="text/javascript" src="'.URL_BASE_JS.'jquery/jquery-1.11.0.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                var $mainContainer = $("#main-container");

                $mainContainer.css({
                    "height": (
                            parseInt($(window).height())
                            - (parseInt($mainContainer.css("margin-top")) * 2)
                            - (parseInt($mainContainer.css("padding-top")) * 2)
                            - (parseInt($mainContainer.css("border-top-width")) * 2)
                        ) +"px"
                });

                $(window).resize(function () {
                    $mainContainer.css({
                        "height": (
                                parseInt($(window).height())
                                - (parseInt($mainContainer.css("margin-top")) * 2)
                                - (parseInt($mainContainer.css("padding-top")) * 2)
                                - (parseInt($mainContainer.css("border-top-width")) * 2)
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
        </span><br />';
        return $html;
    }



    public function renderFooter ()
    {
        $html = '</div><!-- #main-container -->
        </body></html>';
        return $html;
    }

}
