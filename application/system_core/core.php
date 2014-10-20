<?php

// Get other core files
$files = array(
        'database',
        'form',
        'pbkdf2'
    );
foreach ($files as $file) {
    $filepath = DIR_SYSTEM_CORE.DS.'core_'.$file.'.php';
    if (file_exists($filepath)) {
        require_once($filepath);
    } else {
        exit('Fatal Error: One of the core files, '.$filepath.', is missing.<br />Please contact your System Administrators to fix this problem.<br />Exiting...');
    }
}

class SystemCore
{

    public function __construct ()
    {

    }



    public function __destruct ()
    {

    }



    public function transformDate ($date)
    {
        $months = array(
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            );
        $dateSplit = explode('-', $date);
        $dateYear = $dateSplit[0];
        $dateMonth = $months[intval($dateSplit[1]) - 1];
        $dateDay = $dateSplit[2];
        return $dateMonth.' '.$dateDay.', '.$dateYear;
    }



    public function minifyString ($string)
    {
        $pattern = '/(\r|\n|\r\n|\s\s+)/';
        $string = preg_replace($pattern, '', $string);
        return $string;
    }



    public function isEmailValid ($emailAddress)
    {
        return filter_var($emailAddress, FILTER_VALIDATE_EMAIL);
    }



    public function renderPage ($contents)
    {
        $cPages = new ControllerPages();
        $header = $cPages->renderHeader();
        $footer = $cPages->renderFooter();
        $pageHtml = $header.$contents.$footer;
        $pageHtml = $this->minifyString($pageHtml);
        return $pageHtml;
    }



    public function generateQrCode ($content, $filename=null)
    {
        $pluginFilepath = DIR_PLUGINS.DS.'phpqrcode'.DS.'qrlib.php';
        $imageDir = DIR_PUBLIC.DS.'img'.DS.'qrcodes';

        if (!class_exists('QRcode')) {
            if (file_exists($pluginFilepath)) {
                require_once($pluginFilepath);
            } else {
                // Log error
                exit('System Error: Plugin file, phpqrcode, is missing.');
            }
        }

        $rawFilename = $filename;
        if ($filename !== null) {
            $filename = $imageDir.DS.$filename.'.png';
        }

        if (!file_exists($filename)) {
            if ($filename === null) {
                QRcode::png($content);
            } else {
                QRcode::png($content, $filename);
            }
        }

        $imgTag = '<img width="200" height="200" src="'.URL_BASE.'public/img/qrcodes/'.$rawFilename.'.png" />';
        $errorString = 'QR code is not available';
        return file_exists($filename) ? $imgTag : $errorString;
    }

}
