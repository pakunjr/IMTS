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
            $html2pdf->pdf->SetAuthor(SYSTEM_AUTHOR);
            $html2pdf->pdf->SetTitle(SYSTEM_NAME.' '.SYSTEM_VERSION);
            $html2pdf->pdf->SetSubject('Generated Document by '.SYSTEM_NAME.' '.SYSTEM_VERSION);
            $html2pdf->pdf->SetKeywords('Inventory, Monitoring, Tracking, System, Items, Owners, Lorma, Colleges, Palmer, PakunJr, Pakun');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content);
            $html2pdf->Output($filename.'.pdf');
        }
    }



    public function pdfHeader () {
        $file = DIR_TEMPLATE.DS.'header_printable.php';
        if (file_exists($file)) {
            ob_start();
            require_once($file);
            $contents = ob_get_clean();
            return $contents;
        } else return 'Printable header file is missing.';
    }



    public function pdfFooter () {
        $file = DIR_TEMPLATE.DS.'footer_printable.php';
        if (file_exists($file)) {
            ob_start();
            require_once($file);
            $contents = ob_get_clean();
            return $contents;
        } else return 'Printable footer file is missing.';
    }

}
