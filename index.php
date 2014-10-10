<?php

$file = dirname(__FILE__).DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'index.php';
if (file_exists($file)) {
    require_once($file);
    exit();
} else {
    echo '<!DOCTYPE html><html><head>
        <title>Fatal Error</title>
        </head><body>
        <div style="color: #f00;">
            Error: Sorry, something went wrong with the system.<br />
            Please send us an email if you see this message.<br />
            Thank you.<br />
            <br />
            <a href="mailto:sysdev@lorma.edu">Email us at sysdev@lorma.edu, just click here.</a>
        </div>
        </body></html>';
}
