<?php

class myFunctions {

    public function __construct () {

    }



    public function getEnum ($tableName, $fieldName) {
        $db = new database();
        $sqlQuery = "SHOW COLUMNS FROM $tableName";
        $results = $db->statement(array(
            'q' => $sqlQuery));
        if (count($results) > 0) {
            $enum = '';

            foreach ($results as $result) {
                if ($result['Field'] == $fieldName) {
                    $enum = $result['Type'];
                }
            }

            $enum = trim($enum, 'enum(');
            $enum = trim($enum, ')');
            $enum = trim($enum, '\'');
            $enum = explode('\',\'', $enum);

            return $enum;
        } else
            return null;
    }



    public function enumSelectOptions ($tableName, $fieldName) {
        $enum = $this->getEnum($tableName, $fieldName);

        if (is_array($enum)) {
            $array = array();

            foreach ($enum as $en) {
                $array[$en] = $en;
            }

            return $array;
        } else
            return null;
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



    public function minifyString ($string) {
        $patterns = array(
            '/\s\s+/'
            ,'/\r\n/'
            ,'/\n/');
        $replacements = array();
        foreach ($patterns as $p) {
            array_push($replacements, '');
        }
        $string = preg_replace($patterns, $replacements, $string);
        return $string;
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
            ? '<img width="200" height="200" src="'.URL_BASE.'public/img/qrcodes/'.$rawFilename.'.png" />'
            : 'QR Code is not available';
    }

}
