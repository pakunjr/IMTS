<?php

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
        if (strlen($date) > 10) {
            $tmpDate = $date;
            $date = substr($tmpDate, 0, 9);
            $time = ' '.substr($tmpDate, 11, 18);
        } else {
            $time = '';
        }

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
        $transformedDate = $dateMonth.' '.$dateDay.', '.$dateYear;
        return $transformedDate.$time;
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



    public function unserializeable ($string)
    {
        return @unserialize($string) === false ? false : true;
    }



    public function displayPage ($contents, $contentsOnly=false)
    {
        // The header and the footer of the page rendered by
        // this method depends on the method of the Class
        // ViewPages' renderHeader and renderFooter
        if (
            class_exists('ControllerPages') &&
            method_exists('ControllerPages', 'renderHeader') &&
            method_exists('ControllerPages', 'renderFooter') &&
            $contentsOnly === false
        ) {
            $cPages = new ControllerPages();
            $header = $cPages->renderHeader();
            $footer = $cPages->renderFooter();
            $pageHtml = $header.$contents.$footer;
            $pageHtml = $this->minifyString($pageHtml);
        } else {
            $pageHtml = $this->minifyString($contents);
        }
        exit($pageHtml.'<!-- System Exited -->');
    }



    public function renderThemeHeader ()
    {
        $file = DIR_TEMPLATE.DS.'header.php';
        if (file_exists($file)) {
            ob_start();
            require_once($file);
            $contents = ob_get_clean();
        } else {
            $contents = '<!-- Template Error: Template file, '.$file.', is missing.';
        }
        return $contents;
    }



    public function renderThemeFooter ()
    {
        $file = DIR_TEMPLATE.DS.'footer.php';
        if (file_exists($file)) {
            ob_start();
            require_once($file);
            $contents = ob_get_clean();
        } else {
            $contents = '<!-- Template Error: Template file, '.$file.', is missing.';
        }
        return $contents;
    }



    public function renderPageTitle ($pageTitle='Les Actes')
    {
        if ($pageTitle === 'Les Actes') {
            $pageTitle = '<img src="'.URL_BASE_IMG.'system_logo_actions_30x30.png" style="display: inline-block; margin: 0px 10px 0px 0px;" />'.$pageTitle;
        }
        return '<span class="typo-type-1" style="color: #005b7f;">'.$pageTitle.'</span><div class="hr-light"></div>';
    }



    public function redirectPage ($message, $url)
    {
        $filepath = DIR_TEMPLATE.DS.'redirect.php';
        if (file_exists($filepath)) {
            ob_start();
            require_once($filepath);
            ob_end_flush();
        } else {
            header('location: '.$url);
        }
        exit('<!-- System Exited -->');
    }



    public function checkPaths ($paths=array())
    {
        if (!empty($paths) && is_array($paths)) {
            $checking = '';
            foreach ($paths as $path) {
                if (file_exists($path)) {
                    $checking .= 'The path, '.$path.', exists.<br />';
                } else {
                    $checking .= 'The path, '.$path.', do not exists.<br />';
                }
            }
            return $checking;
        } else {
            return 'The Method, checkPaths, of the Class, SystemCore, only accepts array variables with content.';
        }
    }



    public function generateQrCode ($content, $filename=null)
    {
        $pluginFilepath = DIR_PLUGINS.DS.'phpqrcode'.DS.'qrlib.php';
        $imageDir = DIR_PUBLIC.DS.'img'.DS.'qrcodes';

        if (!class_exists('QRcode')) {
            if (file_exists($pluginFilepath)) {
                require_once($pluginFilepath);
            } else {
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
