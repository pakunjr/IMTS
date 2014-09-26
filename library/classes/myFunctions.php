<?php

class myFunctions {

    public function __construct () {

    }



    public function readArray ($array) {
        return '<pre>'.print_r($array, true).'</pre>';
    }



    public function dateToWords ($myDate) {
        if ($myDate == '0000-00-00')
            return 'N/A';

        $months = array(
            'Jan'
            ,'Feb'
            ,'Mar'
            ,'Apr'
            ,'May'
            ,'Jun'
            ,'Jul'
            ,'Aug'
            ,'Sep'
            ,'Oct'
            ,'Nov'
            ,'Dec');

        $splitDate = explode('-', $myDate);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $day = $splitDate[2];

        return $months[intval($month) - 1].' '.$day.', '.$year;
    }



    public function isEmail ($emailAddress) {
        if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) return true;
        else return false;
    }



    public function isAccessible ($leastAccessLevel) {
        $userAccessLevel = isset($_SESSION['user']) ? $_SESSION['user']['accessLevel'] : null;
        $ual = $userAccessLevel;
        $lal = $leastAccessLevel;

        switch ($lal) {
            case 'Administrator':
                return in_array($ual, array('Administrator')) ? true : false;
                break;

            case 'Supervisor':
                return in_array($ual, array('Administrator', 'Supervisor'))
                    ? true : false;
                break;

            case 'Content Provider':
                return in_array($ual, array('Administrator', 'Supervisor', 'Content Provider'))
                    ? true : false;
                break;

            case 'Viewer':
                return in_array($ual, array('Administrator', 'Supervisor', 'Content Provider', 'Viewer'))
                    ? true : false;
                break;

            default:
        }
    }



    public function generateQrCode ($content, $filename=null) {
        $c_errors = new controller_errors();

        $pluginFile = DIR_PLUGINS.DS.'phpqrcode'.DS.'qrlib.php';
        $imageDir = DIR_PUBLIC.DS.'img'.DS.'qrcodes';
        if (!class_exists('QRcode')) {
            if (file_exists($pluginFile))
                require_once($pluginFile);
            else
                $c_errors->logError('Plugin file for phpqrcode is missing.');
        }

        $rawFilename = $filename;
        $filename = $filename != null
            ? $imageDir.DS.$filename.'.png'
            : null;

        if (!file_exists($filename)) {
            if ($filename == null)
                QRcode::png($content);
            else
                QRcode::png($content, $filename);
        }

        return file_exists($filename)
            ? '<img width="250" height="250" src="'.URL_BASE.'public/img/qrcodes/'.$rawFilename.'.png" />'
            : 'QR Code is not available';
    }

}
