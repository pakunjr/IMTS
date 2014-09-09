<?php

class myFunctions {

    public function __construct () {

    }



    public function readArray ($array) {
        return '<pre>'.print_r($array, true).'</pre>';
    }



    public function dateToWords ($myDate) {
        if ( $myDate == '0000-00-00' )
            return 'N/A';

        $months = array(
            'January'
            ,'February'
            ,'March'
            ,'April'
            ,'May'
            ,'June'
            ,'July'
            ,'August'
            ,'September'
            ,'October'
            ,'November'
            ,'December');

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



    public function pdfCreate ($options=array()) {
        $file = DIR_PLUGINS.DS.'html2pdf'.DS.'html2pdf.class.php';
        if (file_exists($file)) {
            $filename = isset($options['filename'])
                ? $options['filename']
                : 'Unknown';
            $content = isset($options['content'])
                ? $options['content']
                : '<style type="text/css"></style><page>'
                    .$this->pdfHeader()
                    .'No content has been set.'
                    .$this->pdfFooter()
                .'</page>';

            ob_start();
            require_once($file);
            $html2pdf = new HTML2PDF('P', 'A4', 'en');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content);
            $html2pdf->Output($filename.'.pdf');
        }
    }



    public function pdfHeader () {
        $output = '<page_header style="font-size: 7pt; color: #595959;">'
            .SYSTEM_NAME_SHORT.' - '.SYSTEM_NAME.' '.SYSTEM_VERSION
            .'<div class="hr" style="background: #595959;"></div>'
            .'</page_header>';
        return $output;
    }



    public function pdfFooter () {
        $loggedUser = isset($_SESSION['user']) ? '<b>'.$_SESSION['user']['username'].'</b> :: <b>'.$_SESSION['user']['name'].'</b>' : 'an <b>Anonymous Person</b>';

        $output = '<page_footer style="font-size: 7pt; color: #595959;">'
            .'<div class="hr" style="background: #595959;"></div>'
            .'This document is generated through <b>'.SYSTEM_NAME.' '.SYSTEM_VERSION.'</b>.<br />'
            .'Date of Generation: <b>'.date('Y-m-d @ H:i:s').'</b><br />'
            .'Generated by '.$loggedUser.'<br />'
            .'Lorma Colleges &copy; '.SYSTEM_YEAR_START.' - '.date('Y').'<br />'
            .'Page [[page_cu]] of [[page_nb]]'
            .'</page_footer>';
        return $output;
    }

}
