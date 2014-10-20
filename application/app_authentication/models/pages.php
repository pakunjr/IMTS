<?php

class ModelPages extends Database
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    public function validateLogin ()
    {
        if (empty($_POST)) {
            exit('User Error: You cannot access this page directly.');
        }

        $core = new SystemCore();

        $username = $_POST['username'];
        $password = $_POST['password'];

        $pbkdf2 = new pbkdf2();

        $query = "SELECT * FROM admin_accounts
            WHERE account_username = ?
            LIMIT 1";
        $values = array(
                $username
            );
        $results = $this->statement($query, $values);
        if (!empty($results)) {
            $r = $results[0];
            $correctHash = $r['account_password_hash'];
            $validation = $pbkdf2->validate_password($password, $correctHash);
            if ($validation) {
                $_SESSION['user'] = array(
                        'accountId' => $r['account_id'],
                        'username' => $r['account_username'],
                        'user' => 'N/A',
                        'accessLevel' => $r['account_access_level']
                    );
                header('location: '.URL_BASE);
            } else {
                $msg
                $url = URL_BASE;
            }
        } else {
            $msg = 'User Error: Invalid username and password combination.<br />Please try again.';
            $url = URL_BASE;
        }
        $core->redirectPage($msg, $url);
    }

}
