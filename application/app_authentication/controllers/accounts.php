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



    public function processLogin ()
    {
        $core = new SystemCore();
        $log = new Log();

        if (empty($_POST)) {
            $msg = 'User Error: You cannot access this page directly.';
            $url = URL_BASE;
            $core->redirectPage($msg, $url);
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $results = $this->validateUser($username);
        if (!empty($results)) {
            $r = $results[0];

            // Validate employment
            $employments = $this->validateEmployment($r['account_owner']);
            if (!empty($employments)) {
                // Get departments and jobs of the user
                $departments = array();
                $jobs = array();
                foreach ($employments as $emp) {
                    array_push($departments, $emp['department_name']);
                    array_push($jobs, $emp['employee_job_label']);
                }

                // Process username and password validation
                $correctHash = $r['account_password_hash'];
                $validation = $this->validate_password(
                        $password,
                        $correctHash
                    );
                if ($validation) {
                    $_SESSION['user'] = array(
                            'accountId' => $r['account_id'],
                            'personId' => $r['person_id'],
                            'username' => $r['account_username'],
                            'user' => $r['person_lastname'].', '.
                                $r['person_firstname'].' '.
                                $r['person_middlename'].' '.
                                $r['person_suffix'],
                            'departments' => $departments,
                            'jobs' => $jobs,
                            'accessLevel' => $r['account_access_level']
                        );
                    header('location: '.URL_BASE);
                    exit();
                } else {
                    $msg = 'User Error: Invalid username and password combination.<br />Please try again.';
                    $url = URL_BASE;
                }
            } else {
                $msg = 'We\'re sorry to inform you that you are no longer qualified to use this account.';
                $url = URL_BASE;
            }
        } else {
            $msg = 'User Error: Invalid username and password combination.<br />Please try again.';
            $url = URL_BASE;
        }
        $core->redirectPage($msg, $url);
    }

}
