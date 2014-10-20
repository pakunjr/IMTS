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
    }

}
