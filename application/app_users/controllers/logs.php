<?php

class ControllerLogs extends ViewLogs
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    public function displayHomepage ()
    {
        echo $this->renderHomepage();
    }



    public function displayLogContent (
        $type='system',
        $systemLogStatus='Displayed'
    ) {
        echo $this->renderLogContent($type, $systemLogStatus);
    }



    public function cleanLogs ($type='system')
    {
        $core = new SystemCore();
        switch ($type) {
            case 'database':
                $result = $this->cleanDatabaseLog();
                if ($result) {
                    $msg = 'The system have sucessfully cleaned your database log file.';
                } else {
                    $msg = 'The system failed to clean your database log file.';
                }
                $url = URL_BASE.'user_settings/logs/database/';
                break;

            case 'system':
            default:
                $result = $this->archiveLogs();
                if ($result) {
                    $msg = 'The system have successfully cleaned your system logs.';
                } else {
                    $msg = 'The system failed to clean your system logs.';
                }
                $url = URL_BASE.'user_settings/logs/system/';
        }
        $core->redirectPage($msg, $url);
    }

}
