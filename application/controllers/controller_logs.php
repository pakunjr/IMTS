<?php

class controller_logs {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_logs();
        $this->view = new view_logs();
    }



    public function __destruct () {

    }



    public function logAction ($details, $logLevel='Notice') {
        $datas = array(
            'log-type' => 'Action'
            ,'log-level' => $logLevel
            ,'log-details' => $details);
    }



    public function logError ($details, $logLevel='Notice') {
        $datas = array(
            'log-type' => 'Error'
            ,'log-level' => $logLevel
            ,'log-details' => $details);
    }



    public function displayLog ($logId) {
        $datas = $this->model->readLog($logId);
        // Do nothing at the moment...
    }



    public function displayLogs () {
        $datas = $this->model->readLogs();
        echo $this->view->renderLogs($datas);
    }

}
