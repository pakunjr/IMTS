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

}
