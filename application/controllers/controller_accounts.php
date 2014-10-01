<?php

class controller_accounts {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_accounts();
        $this->view = new view_accounts();
    }



    public function __destruct () {

    }



    public function createAccount () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $msg = '<span style="color: #f00;">Error</span>: You can\'t access this page direclty.';
            $redirectUrl = URL_BASE.'accounts/create_account/';
            $c_pages->pageRedirect($msg, $redirectUrl);
        }

        $res = $this->model->createAccount($_POST);
        if ($res != null) {
            $msg = 'Account has been created successfully.';
            $redirectUrl = URL_BASE.'accounts/read_account/'.$res['account-id'].'/';
        } else {
            $msg = '<span style="color: #f00;">Error</span>: Account was not created.';
            $redirectUrl = URL_BASE.'accounts/create_account/';
        }
        
        $c_pages->pageRedirect($msg, $redirectUrl);
    }



    public function updateAccount () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $msg = '<span style="color: #f00;">Error</span>: You can\'t access this page direclty.';
            $redirectUrl = URL_BASE.'accounts/';
            $c_pages->pageRedirect($msg, $redirectUrl);
        }

        $res = $this->model->updateAccount($_POST);

        if ($res) {
            $msg = 'The account has been updated successfully.';
            $redirectUrl = URL_BASE.'accounts/read_account/'.$res['account-id'].'/';
        } else {
            $msg = 'The account failed to be udpated.';
            $redirectUrl = URL_BASE.'accounts/read_account/'.$res['account-id'].'/';
        }

        $c_pages->pageRedirect($msg, $redirectUrl);
    }



    public function updatePassword () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            header('location: '.URL_BASE);
            return;
        }

        if ($_POST['new-password'] != $_POST['new-password-confirm']) {
            $msg = '<span style="color: #f00;">Error</span>: Your `New Password` and `Confirm New Password` did not match, please try again.';
            $redirectUrl = URL_BASE.'accounts/update_password/'.$_POST['account-id'].'/';
            $c_pages->pageRedirect($msg, $redirectUrl);
        } else if (strlen(trim($_POST['new-password'])) < 5) {
            $msg = '<span style="color: #f00;">Error</span>: Your new password must be 5 or more characters long.';
            $redirectUrl = URL_BASE.'accounts/update_password/'.$_POST['account-id'].'/';
            $c_pages->pageRedirect($msg, $redirectUrl);
        }

        $res = $this->model->updatePassword(
            $_POST['account-id']
            ,$_POST['old-password']
            ,$_POST['new-password']);

        if ($res) {
            $msg = 'Logging out, please login again with your new password.<br /><br />Thank you.';
            $redirectUrl = URL_BASE.'/accounts/logout/';
            $c_pages->pageRedirect($msg, $redirectUrl);
        } else {
            $msg = '<span style="color: #f00;">Error</span>: The system failed to change your password due to some reason/s.
                <div class="hr-light"></div>
                <ul>
                <li>The old password you have provided did not match your current password.</li>
                <li>The system is having a hard time saving your new password into the database due to some unknown reason.</li>
                </ul>';
            $redirectUrl = URL_BASE.'accounts/update_password/'.$_POST['account-id'].'/';
            $c_pages->pageRedirect($msg, $redirectUrl);
        }
    }



    public function activateAccount ($accountId) {
        $c_pages = new controller_pages();
        $status = $this->model->activateAccount($accountId);
        if ($status) {
            $msg = 'Account has been activated successfully.';
            $redirectUrl = URL_BASE.'accounts/read_account/'.$accountId.'/';
        } else {
            $msg = '<span style="color: #f00;">Error</span>: Account is not activated, something went wrong.';
            $redirectUrl = URL_BASE.'accounts/read_account/'.$accountId.'/';
        }
        $c_pages->pageRedirect($msg, $redirectUrl);
    }



    public function deactivateAccount ($accountId) {
        $c_pages = new controller_pages();
        $status = $this->model->deactivateAccount($accountId);

        if ($_SESSION['user']['username'] != 'admin') {
            if ($_SESSION['user']['accountId'] == $accountId) {
                $msg = 'Your account has been deactivated, you are now being logged out.';
                $redirectUrl = URL_BASE.'accounts/logout/';
            } else {
                $msg = 'The account has been deactivated';
                $redirectUrl = URL_BASE.'accounts/read_account/'.$accountId.'/';
            }
        } else {
            $msg = 'The account has been deactivated.';
            $redirectUrl = URL_BASE.'accounts/read_account/'.$accountId.'/';
        }

        $c_pages->pageRedirect($msg, $redirectUrl);
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
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You can\'t access this page directly.';
            $u = URL_BASE;
            $c_pages->pageRedirect($m, $u);
        }

        $status = $this->model->validateLogin($_POST);

        if (!$status) {
            $msg = '<span style="color: #f00;">Error</span>: Invalid Username and Password combination';
            $redirectUrl = URL_BASE;
            $c_pages->pageRedirect($msg, $redirectUrl);
        } else
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
