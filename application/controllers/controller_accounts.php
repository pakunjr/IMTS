<?php

class controller_accounts {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_accounts();
        $this->view = new view_accounts();
    }



    public function createAccount () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'accounts/');
            return;
        }

        $res = $this->model->createAccount($_POST);
        if ($res != null) header('location: '.URL_BASE.'accounts/read_account/'.$res['account-id'].'/');
        else header('location: '.URL_BASE.'accounts/create_account/');
    }



    public function updateAccount () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE.'accounts/');
            return;
        }

        $res = $this->model->updateAccount($_POST);
        header('location: '.URL_BASE.'accounts/read_account/'.$res['account-id'].'/');
    }



    public function updatePassword () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE);
            return;
        }

        if ($_POST['new-password'] != $_POST['new-password-confirm']
            || strlen(trim($_POST['new-password'])) < 5) {
            header('location: '.URL_BASE.'accounts/read_account/'.$_POST['account-id'].'/');
            return;
        }

        $res = $this->model->updatePassword(
            $_POST['account-id']
            ,$_POST['old-password']
            ,$_POST['new-password']);

        if ($res) header('location: '.URL_BASE.'accounts/logout/');
        else header('location: '.URL_BASE.'accounts/read_account/'.$_POST['account-id'].'/');
    }



    public function activateAccount ($accountId) {
        $this->model->activateAccount($accountId);
        header('location: '.URL_BASE.'accounts/read_account/'.$accountId.'/');
    }



    public function deactivateAccount ($accountId) {
        $this->model->deactivateAccount($accountId);

        if ($_SESSION['user']['username'] != 'admin') {
            if ($_SESSION['user']['accountId'] == $accountId) {
                header('location: '.URL_BASE.'accounts/logout/');
                return;
            } else header('location: '.URL_BASE.'accounts/read_account/'.$accountId.'/');
        } else header('location: '.URL_BASE.'accounts/read_account/'.$accountId.'/');
    }



    public function displayForm ($personId, $accountId=null) {
        $datas = $this->model->readAccount($accountId);
        echo $this->view->renderForm($personId, $datas);
    }



    public function displayLoginForm () {
        if (isset($_SESSION['user']))
            echo $this->view->renderLoginWelcome();
        else
            echo $this->view->renderLoginForm();
    }



    public function displayChangePasswordForm ($accountId) {
        $datas = $this->model->readAccount($accountId);
        echo $this->view->renderChangePasswordForm($accountId, $datas);
    }



    public function displayAccessLevelSelect ($options, $echo=false) {
        $accessLevels = $this->model->readAccessLevels();
        $output = $this->view->renderAccessLevelSelect($options, $accessLevels);
        if (!$echo) return $output;
        echo $output;
    }



    public function displayAccountInformations ($accountId) {
        $datas = $this->model->readAccount($accountId);
        echo $this->view->renderAccountInformations($datas);
    }



    public function displayPersonAccounts ($personId, $echo=true) {
        $accounts = $this->model->readPersonAccounts($personId);
        $output = $this->view->renderPersonAccounts($accounts);
        if (!$echo) return $output;
        echo $output;
    }



    public function displayAccountName ($accountId, $echo=true) {
        $a = $this->model->readAccount($accountId);
        $output = $this->view->renderAccountName($a);
        if (!$echo) return $output;
        echo $output;
    }



    public function loginUser () {
        if (!isset($_POST)) {
            header('location: '.URL_BASE);
            return;
        }

        $this->model->validateLogin($_POST);
        header('location: '.URL_BASE);
    }



    public function logoutUser () {
        session_destroy();
        header('location: '.URL_BASE);
    }



    public function getAccessLevel ($accountId) {
        $account = $this->model->readAccount($accountId);
        $accessLevel = $account != null ? $account['access_level_label'] : '';
        return $accessLevel;
    }



    public function getLoginDetails () {

    }

}
