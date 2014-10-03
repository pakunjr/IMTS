<?php

class model_accounts {

    private $db;
    private $pbkdf2;

    public function __construct () {
        $this->db = new database();
        $this->pbkdf2 = new pbkdf2();
    }



    public function __destruct () {

    }



    public function createAccount ($datas) {
        $d = $datas;
        $fx = new myFunctions();
        
        if ($d['account-password'] != $d['account-password-confirm'])
            return null;

        $passwordHash = $this->passwordEncrypt($d['account-password']);
        $currentDate = date('Y-m-d');
        $res = $this->db->statement(array(
            'q'=>"INSERT INTO imts_accounts(
                    account_username
                    ,account_password_hash
                    ,account_owner
                    ,account_access_level
                    ,account_deactivated
                    ,account_date_created
                ) VALUES(?,?,?,?,?,?)"
            ,'v'=>array(
                $d['account-username']
                ,$passwordHash
                ,intval($d['account-owner'])
                ,intval($d['account-access-level'])
                ,intval(1)
                ,$currentDate)));
        if ($res) {
            $d['account-id'] = $this->db->lastInsertId();

            //Prepare the email to be sent
            $person = $this->db->statement(array(
                'q'=>"SELECT person_email FROM imts_persons WHERE person_id = ? LIMIT 1"
                ,'v'=>array(intval($d['account-owner']))));
            if (count($person) > 0) {
                $email = $person[0]['person_email'];
                $email = $fx->isEmail($email) ? $email : null;
                if ($email != null) {
                    $to = $email;
                    $subject = 'IMTS Account - Username and Password';
                    $message = 'Please update your profile and change your password as soon as you have opened this email. Thank you.<hr />'
                        .'Username: '.$d['account-username'].'<br />'
                        .'Password: '.$d['account-password'];
                    $headers = "From: imts@lorma.edu\r\n"
                        ."Reply-To: palmer.gawaban@lorma.edu\r\n"
                        ."X-Mailer: PHP/".phpversion()."\r\n"
                        ."X-Priority: 1 (Highest)\r\n"
                        ."X-MSMail-Priority: High\r\n"
                        ."Importance: High\r\n"
                        ."MIME-Version: 1.0\r\n"
                        ."Content-type: text/html; charset=ISO-8859-1\r\n";
                        
                    mail($to, $subject, $message, $headers);
                }
            }
            return $d;
        } else {
            $c_errors = new controller_errors();
            $c_persons = new controller_persons();
            $c_errors->logError('Failed to create account for '.$d['account-username'].' -- '.$c_persons->displayPersonName($d['account-owner'], false));
            return null;
        }
    }



    private function createMasterUser () {
        $personRes = $this->db->statement(array(
            'q'=>"INSERT INTO imts_persons(
                    person_firstname
                    ,person_email
                ) VALUES(
                    'admin'
                    ,'admin@admin.com'
                )"));
        $personId = $this->db->lastInsertId();

        $adminId = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_accounts_access_level WHERE access_level_label = 'Administrator' OR access_level_label = 'Admin' LIMIT 1"));
        $adminId = $adminId[0]['access_level_id'];

        $password = $this->passwordEncrypt('admin');
        $currentDate = date('Y-m-d');
        $accountRes = $this->db->statement(array(
            'q'=>"INSERT INTO imts_accounts(
                    account_username
                    ,account_password_hash
                    ,account_owner
                    ,account_access_level
                    ,account_deactivated
                    ,account_date_created
                ) VALUES(
                    'admin'
                    ,'$password'
                    ,$personId
                    ,$adminId
                    ,0
                    ,'$currentDate'
                )"));
        if (!$accountRes) {
            $c_errors = new controller_errors();
            $c_errors->logError('Failed to create Master Account. admin - admin');
        }
        return $accountRes;
    }



    public function readAccount ($accountId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_accounts AS acc
                LEFT JOIN imts_persons AS per
                    ON acc.account_owner = per.person_id
                LEFT JOIN imts_accounts_access_level AS acl
                    ON acc.account_access_level = acl.access_level_id
                WHERE account_id = ? LIMIT 1"
            ,'v'=>array(intval($accountId))));
        return count($rows) > 0 ? $rows[0] : null;
    }



    public function readPersonAccounts ($personId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_accounts AS acc
                LEFT JOIN imts_accounts_access_level AS acl
                    ON acc.account_access_level = acl.access_level_id
                WHERE acc.account_owner = ?"
            ,'v'=>array(intval($personId))));
        return count($rows) > 0 ? $rows : null;
    }



    public function readAccessLevels () {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_accounts_access_level"));
        return count($rows) > 0 ? $rows : null;
    }



    public function updateAccount ($datas) {
        $d = $datas;

        $oldData = $this->readAccount($d['account-id']);
        if ($oldData['account_username'] == 'admin') return null;
        if ($oldData['account_username'] != $d['account-username']) {
            if ($this->isUsernameTaken($d['account-username']))
                return null;
        }

        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_accounts
                SET account_username = ?
                    ,account_access_level = ?
                WHERE account_id = ?"
            ,'v'=>array(
                $d['account-username']
                ,intval($d['account-access-level'])
                ,intval($d['account-id']))));
        if (!$res) {
            $c_errors = new controller_errors();
            $c_accounts = new controller_accounts();
            $c_errors->logError('Failed to update account of '.$c_accounts->displayAccountName($oldData['account_id'], false).'.');
        }
        return $res ? $d : null;
    }



    public function updatePassword ($accountId, $old, $new) {
        $account = $this->readAccount($accountId);

        if ($account == null) return false;

        $currentPassword = $account['account_password_hash'];
        if ($this->passwordValidate($old, $currentPassword)) {
            $newHash = $this->passwordEncrypt($new);
            $res = $this->db->statement(array(
                'q'=>"UPDATE imts_accounts SET account_password_hash = ? WHERE account_id = ?"
                ,'v'=>array(
                    $newHash
                    ,intval($accountId))));
            return $res;
        } else {
            $c_errors = new controller_errors();
            $c_errors->logError('Failed to change password of '.$account['account_username'].' -- '.$account['person_lastname'].', '.$account['person_firstname'].' '.$account['person_middlename'].' '.$account['person_suffix']);
            return false;
        }
    }



    public function activateAccount ($accountId) {
        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_accounts SET account_deactivated = 0 WHERE account_id = ?"
            ,'v'=>array(intval($accountId))));
        if (!$res) {
            $c_errors = new controller_errors();
            $c_accounts = new controller_accounts();
            $c_errors->logError('Failed to Activate the account '.$c_accounts->displayAccountName($accountId, false).'.');
        }
        return $res;
    }



    public function deactivateAccount ($accountId) {
        $res = $this->db->statement(array(
            'q'=>"UPDATE imts_accounts SET account_deactivated = 1 WHERE account_id = ?"
            ,'v'=>array(intval($accountId))));
        if (!$res) {
            $c_errors = new controller_errors();
            $c_accounts = new controller_accounts();
            $c_errors->logError('Failed to Deactivate the account '.$c_accounts->displayAccountName($accountId, false).'.');
        }
        return $res;
    }



    public function validateLogin ($datas) {
        $admin = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_accounts WHERE account_username = 'admin' LIMIT 1"));

        if (count($admin) < 1) {
            $this->createMasterUser();
        }

        $d = $datas;
        $username = isset($d['username']) ? $d['username'] : '';
        $password = isset($d['password']) ? $d['password'] : '';

        $fx = new myFunctions();

        if ($fx->isEmail($username)) {
            $rows = $this->db->statement(array(
                'q'=>"SELECT * FROM imts_accounts AS acc
                    LEFT JOIN imts_persons AS per
                        ON acc.account_owner = per.person_id
                    LEFT JOIN imts_accounts_access_level AS acl
                        ON acc.account_access_level = acl.access_level_id
                    WHERE per.email_address = ?
                    LIMIT 1"
                ,'v'=>array($username)));
        } else {
            $rows = $this->db->statement(array(
                'q'=>"SELECT * FROM imts_accounts AS acc
                    LEFT JOIN imts_persons AS per
                        ON acc.account_owner = per.person_id
                    LEFT JOIN imts_accounts_access_level AS acl
                        ON acc.account_access_level = acl.access_level_id
                    WHERE acc.account_username = ?
                    LIMIT 1"
                ,'v'=>array($username)));
        }

        if (count($rows) < 1)
            return false;

        $rows = $rows[0];

        if ($username != 'admin' && $rows['account_deactivated'] == '1')
            return false;

        $hash = $rows['account_password_hash'];
        if ($this->passwordValidate($password, $hash)) {
            $_SESSION['user'] = array(
                'accountId'=>$rows['account_id']
                ,'username'=>$rows['account_username']
                ,'accessLevel'=>$rows['access_level_label']
                ,'name'=>$rows['person_lastname'].', '.$rows['person_firstname'].' '.$rows['person_middlename'].' '.$rows['person_suffix']
                ,'personId'=>$rows['person_id']);
            return true;
        } else
            return false;
    }



    public function passwordValidate ($password, $hash) {
        return $this->pbkdf2->validate_password($password, $hash);
    }



    public function passwordEncrypt ($password) {
        return $this->pbkdf2->create_hash($password);
    }



    public function isUsernameTaken ($username) {
        $fx = new myFunctions();

        if ($fx->isEmail($username)) {
            $rows = $this->db->statement(array(
                'q'=>"SELECT * FROM imts_persons WHERE person_email = ?"
                ,'v'=>array($username)));
        } else {
            $rows = $this->db->statement(array(
                'q'=>"SELECT * FROM imts_accounts WHERE account_username = ?"
                ,'v'=>array($username)));
        }

        return count($rows) > 0 ? true : false;
    }

}



class pbkdf2 {

    /*
     * Password Hashing With PBKDF2 (http://crackstation.net/hashing-security.htm).
     * Copyright (c) 2013, Taylor Hornby
     * All rights reserved.
     *
     * Redistribution and use in source and binary forms, with or without 
     * modification, are permitted provided that the following conditions are met:
     *
     * 1. Redistributions of source code must retain the above copyright notice, 
     * this list of conditions and the following disclaimer.
     *
     * 2. Redistributions in binary form must reproduce the above copyright notice,
     * this list of conditions and the following disclaimer in the documentation 
     * and/or other materials provided with the distribution.
     *
     * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
     * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
     * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
     * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
     * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
     * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
     * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
     * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
     * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
     * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
     * POSSIBILITY OF SUCH DAMAGE.
     */

    public function __construct () {
        // These constants may be changed without breaking existing hashes.
        defined('PBKDF2_HASH_ALGORITHM')
            or define("PBKDF2_HASH_ALGORITHM", "sha256");
        defined('PBKDF2_ITERATIONS')
            or define("PBKDF2_ITERATIONS", 1000);
        defined('PBKDF2_SALT_BYTE_SIZE')
            or define("PBKDF2_SALT_BYTE_SIZE", 24);
        defined('PBKDF2_HASH_BYTE_SIZE')
            or define("PBKDF2_HASH_BYTE_SIZE", 24);

        defined('HASH_SECTIONS')
            or define("HASH_SECTIONS", 4);
        defined('HASH_ALGORITHM_INDEX')
            or define("HASH_ALGORITHM_INDEX", 0);
        defined('HASH_ITERATION_INDEX')
            or define("HASH_ITERATION_INDEX", 1);
        defined('HASH_SALT_INDEX')
            or define("HASH_SALT_INDEX", 2);
        defined('HASH_PBKDF2_INDEX')
            or define("HASH_PBKDF2_INDEX", 3);
    }

    function create_hash($password)
    {
        // format: algorithm:iterations:salt:hash
        $salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTE_SIZE, MCRYPT_DEV_URANDOM));
        return PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" .  $salt . ":" .
            base64_encode($this->pbkdf2(
                PBKDF2_HASH_ALGORITHM,
                $password,
                $salt,
                PBKDF2_ITERATIONS,
                PBKDF2_HASH_BYTE_SIZE,
                true
            ));
    }

    function validate_password($password, $correct_hash)
    {
        $params = explode(":", $correct_hash);
        if(count($params) < HASH_SECTIONS)
           return false;
        $pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);
        return $this->slow_equals(
            $pbkdf2,
            $this->pbkdf2(
                $params[HASH_ALGORITHM_INDEX],
                $password,
                $params[HASH_SALT_INDEX],
                (int)$params[HASH_ITERATION_INDEX],
                strlen($pbkdf2),
                true
            )
        );
    }

    // Compares two strings $a and $b in length-constant time.
    function slow_equals($a, $b)
    {
        $diff = strlen($a) ^ strlen($b);
        for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
        {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }

    /*
     * PBKDF2 key derivation function as defined by RSA's PKCS #5: https://www.ietf.org/rfc/rfc2898.txt
     * $algorithm - The hash algorithm to use. Recommended: SHA256
     * $password - The password.
     * $salt - A salt that is unique to the password.
     * $count - Iteration count. Higher is better, but slower. Recommended: At least 1000.
     * $key_length - The length of the derived key in bytes.
     * $raw_output - If true, the key is returned in raw binary format. Hex encoded otherwise.
     * Returns: A $key_length-byte key derived from the password and salt.
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     *
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     */
    function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
    {
        $algorithm = strtolower($algorithm);
        if(!in_array($algorithm, hash_algos(), true))
            trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
        if($count <= 0 || $key_length <= 0)
            trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);

        if (function_exists("hash_pbkdf2")) {
            // The output length is in NIBBLES (4-bits) if $raw_output is false!
            if (!$raw_output) {
                $key_length = $key_length * 2;
            }
            return hash_pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output);
        }

        $hash_length = strlen(hash($algorithm, "", true));
        $block_count = ceil($key_length / $hash_length);

        $output = "";
        for($i = 1; $i <= $block_count; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . pack("N", $i);
            // first iteration
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if($raw_output)
            return substr($output, 0, $key_length);
        else
            return bin2hex(substr($output, 0, $key_length));
    }

}
