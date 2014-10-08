<?php

class view_logs {

    public function __construct () {

    }



    public function __destruct () {

    }



    public function renderLogs ($datas=null) {
        if ($datas === null)
            return 'There are no displayed logs at the moment.<br />
                You can try looking at the archived logs.';

        $output = '';
        return $output;
    }

}
