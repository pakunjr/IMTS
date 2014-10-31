<?php

class ControllerAccounts extends ViewAccounts
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {
        
    }



    public function saveChangePassword ()
    {
        $core = new SystemCore();
        if (empty($_POST)) {
            $msg = 'Sorry, you cannot access this page directly.<br />The system will redirect you to the proper page.<br />Thank you.';
            $url = URL_BASE.'user_settings/profile/change_password/';
            $core->redirectPage($msg, $url);
        }

        if (
            $_POST['new-password'] == $_POST['confirm-new-password'] &&
            strlen($_POST['new-password']) > 5
        ) {
            $result = $this->updatePassword(
                    $_SESSION['user']['accountId'],
                    $_POST['old-password'],
                    $_POST['new-password']
                );

            if ($result) {
                $msg = 'You have successfully changed your password.';
                $url = URL_BASE.'user_settings/profile/change_password/';
            } else {
                $msg = 'The system have failed to change your password.<br />You may have incorrectly provided your old password.<br />Please try again.<br /><br />If the problem continue to persist, contact your System Administrators to fix the problem.<br />Thank you.';
                $url = URL_BASE.'user_settings/profile/change_password/';
            }
        } else {
            $msg = 'Sorry, the system cannot proceed on changing your password due to one possible problem listed below:<br />
                <ul>
                <li>New Password and Confirm New Password did not match.</li>
                <li>Your new password must be more than 5 characters.</li>
                </ul>';
            $url = URL_BASE.'user_settings/profile/change_password/';
        }
        $core->redirectPage($msg, $url);
    }

}
