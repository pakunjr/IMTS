<?php

class Accounts extends pbkdf2
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    protected function createAccount ($datas)
    {
        $passwordHash = $this->create_hash($datas['account-password']);
        $query = "INSERT INTO admin_accounts(
                account_username,
                account_password_hash,
                account_owner,
                account_access_level,
                account_datetime_created
            ) VALUES(?,?,?,?,?)";
        $values = array(
                $datas['account-username'],
                $passwordHash,
                intval($datas['account-owner']),
                $datas['account-access-level'],
                date('Y-m-d H:i:s')
            );
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function readAccount ($accountId)
    {
        $query = "SELECT * FROM admin_accounts AS acc
            LEFT JOIN system_persons AS per ON
                acc.account_owner = per.person_id
            WHERE acc.account_id = ?
            LIMIT 1";
        $values = array(intval($accountId));
        $result = $this->statement($query, $values);
        return $result[0];
    }



    protected function readAccounts ($personId=null)
    {
        if ($personId !== null) {
            $query = "SELECT * FROM admin_accounts AS acc
                WHERE acc.account_owner = ?";
            $values = array(intval($personId));
        } else {
            $query = "SELECT * FROM admin_accounts AS acc
                LEFT JOIN system_persons AS per ON
                    acc.account_owner = per.person_id
                ORDER BY
                    acc.account_access_level ASC,
                    acc.account_access_level = 'Administrator',
                    acc.account_access_level = 'Supervisor',
                    acc.account_access_level = 'Content Provider',
                    acc.account_access_level = 'Viewer'";
            $values = array();
        }
        $results = $this->statement($query, $values);
        return $results;
    }



    protected function updateAccount ($datas, $accountId)
    {
        $query = "";
        $values = array();
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function updatePassword (
        $accountId,
        $oldPassword,
        $newPassword
    ) {
        $query = "SELECT * FROM admin_accounts
            WHERE account_id = ?";
        $values = array(intval($accountId));
        $result = $this->statement($query, $values);

        if ($result !== null) {
            $oldHash = $result[0]['account_password_hash'];
            if ($this->validate_password($oldPassword, $oldHash)) {
                $newHash = $this->create_hash($newPassword);
                $query = "UPDATE admin_accounts
                    SET account_password_hash = ?
                    WHERE account_id = ?";
                $values = array(
                        $newHash,
                        intval($accountId)
                    );
                $result = $this->statement($query, $values);
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }



    protected function deleteAccount ($accountId)
    {
        $query = "DELETE FROM admin_accounts
            WHERE account_id = ?";
        $values = array(intval($accountId));
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function searchAccount ($keyword)
    {
        $query = "SELECT * FROM admin_accounts AS acc
            LEFT JOIN system_perosns AS per ON
                acc.account_owner = per.person_id
            WHERE
                acc.account_username = ? OR
                per.person_firstname = ? OR
                per.perosn_middlename = ? OR
                per.person_lastname = ? OR
                per.person_suffix = ?";
        $values = array(
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%",
                "%$keyword%"
            );
        $results = $this->statement($query, $values);
        return $results;
    }



    protected function activateAccount ($accountId)
    {
        $query = "UPDATE admin_accounts
            SET account_deactivated = 0
            WHERE account_id = ?";
        $values = array(intval($accountId));
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function deactivateAccount ($accountId)
    {
        $query = "UPDATE admin_accounts
            SET account_deactivated = 1
            WHERE account_id = ?";
        $values = array(intval($accountId));
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function accountExists ($username)
    {
        $query = "SELECT * FROM admin_accounts AS acc
            LEFT JOIN system_persons AS per ON
                acc.account_owner = per.person_id
            WHERE
                acc.account_username = ? OR
                per.person_email = ?
            LIMIT 1";
        $values = array($username, $username);
        $result = $this->statement($query, $values);
        return $result !== null ? true : false;
    }



    protected function identifyAccountStatus ($accountId)
    {
        $currentDate = date('Y-m-d');
        $accountInfo = $this->readAccount($accountId);
        if ($accountInfo !== null) {
            $query = "SELECT * FROM hr_employees
                WHERE
                    employee_person = ? AND
                    (
                        employee_resignation_date = '0000-00-00' OR
                        employee_resignation_date > '$currentDate'
                        )
                LIMIT 1";
            $values = array(
                    intval($accountInfo['account_owner'])
                );
            $employeeInfo = $this->statement($query, $values);
            return $employeeInfo !== null ? 'Active' : 'Expired';
        } else {
            return 'This account do not exists.';
        }
    }

}



// This is a class automatically salting
// the password and hashing it with
// selected encrypting algorithm
class pbkdf2 extends Database {

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

    public function __construct ()
    {
        parent::__construct();
        
        if (
            !defined('PBKDF2_HASH_ALGORITHM') ||
            !defined('PBKDF2_ITERATIONS') ||
            !defined('PBKDF2_SALT_BYTE_SIZE') ||
            !defined('PBKDF2_HASH_BYTE_SIZE') ||
            !defined('HASH_SECTIONS') ||
            !defined('HASH_ALGORITHM_INDEX') ||
            !defined('HASH_ITERATION_INDEX') ||
            !defined('HASH_SALT_INDEX') ||
            !defined('HASH_PBKDF2_INDEX')
        ) {
            define("PBKDF2_HASH_ALGORITHM", "sha256");
            define("PBKDF2_ITERATIONS", 1000);
            define("PBKDF2_SALT_BYTE_SIZE", 24);
            define("PBKDF2_HASH_BYTE_SIZE", 24);
            define("HASH_SECTIONS", 4);
            define("HASH_ALGORITHM_INDEX", 0);
            define("HASH_ITERATION_INDEX", 1);
            define("HASH_SALT_INDEX", 2);
            define("HASH_PBKDF2_INDEX", 3);
        }
    }

    protected function create_hash($password)
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

    protected function validate_password($password, $correct_hash)
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
    private function slow_equals($a, $b)
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
    private function pbkdf2(
        $algorithm,
        $password,
        $salt,
        $count,
        $key_length,
        $raw_output=false
    ) {
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
