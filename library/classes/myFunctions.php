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



    public function pdfCreate ($options=array()) {
        $file = DIR_PLUGINS.DS.'html2pdf'.DS.'html2pdf.class.php';
        if (file_exists($file)) {
            $filename = isset($options['filename'])
                ? $options['filename']
                : 'Unknown File';
            $content = isset($options['content'])
                ? $this->pdfTemplate($options['content'], $filename)
                : $this->pdfTemplate('Empty PDF file.', $filename);

            try {
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
            } catch (HTML2PDF_exception $e) {
                $c_errors = new controller_errors();
                $c_errors->logError('PDF Generation Failed: '.PHP_EOL.$e);
                echo 'Can\'t produce PDF file.<br />PDF Error: ',$e;
            }
        }
    }



    public function pdfTemplate ($contents, $title='Unknown Document') {
        $loggedUser = isset($_SESSION['user']) ? '<b>'.$_SESSION['user']['name'].'</b>' : 'an <b>Anonymous Person</b>';
        $output = '<style type="text/css">'."
                <!--
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table th,
                table td {
                    margin: 0px;
                    padding: 4px 5px 4px 8px;
                    border: 1px solid #333;
                    font-size: 8pt;
                    vertical-align: middle;
                }
                table th {
                    text-align: center;
                }

                div.hr {
                    display: block;
                    width: 100%;
                    height: 2px;
                    margin: 4px 0px;
                    background: #4d4d4d;
                }
                div.light {
                    height: 1px;
                }
                div.heavy {
                    height: 3px;
                }

                .pdf-header,
                .pdf-footer {
                    display: block;
                    font-size: 7.5pt;
                    font-family: Courier;
                    color: #4d4d4d;
                }
                div.pdf-contents {
                    font-family: Helvetica;
                }
                -->
            ".'</style>'

            .'<page pageset="new" orientation="portrait" format="A4" backcolor="#fff" backleft="0.5in" backright="0.5in" backtop="0.5in" backbottom="1in" footer="">'
                .'<page_header class="pdf-header">'
                    .SYSTEM_NAME_SHORT.' - '.SYSTEM_NAME.' '.SYSTEM_VERSION
                    .'<div class="hr light" style="background: #595959;"></div>'
                .'</page_header>'
                .'<page_footer class="pdf-footer">'
                    .'<div class="hr light" style="background: #595959;"></div>'
                    .'This document is generated through <b>'.SYSTEM_NAME.' '.SYSTEM_VERSION.'</b><br />'
                    .'Generated by '.$loggedUser.' on <b>'.$this->dateToWords(date('Y-m-d')).'</b> @ <b>'.date('H:i:s').'</b> (UTC+08:00)<br />'
                    .'Lorma Colleges &copy; '.SYSTEM_YEAR_START;
        $output .= SYSTEM_YEAR_START < date('Y') ? ' - '.date('Y').'<br />' : '<br />';
        $output .= 'Page <b>[[page_cu]]</b> of <b>[[page_nb]]</b> || '.$title
                .'</page_footer>'

                .'<div class="pdf-contents">'.$contents.'</div>'
            .'</page>';
        return $output;
    }

}
