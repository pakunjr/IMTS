<?php

class ControllerPersons extends ViewPersons
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {
        
    }



    public function displayEmployeeForm ()
    {
        echo $this->renderEmployeeRegistrationForm();
    }



    public function displayEmploymentForm ($employmentId=null)
    {
        echo $this->renderEmploymentForm($employmentId);
    }



    public function displayEndEmployment ($personId)
    {
        echo $this->renderEndEmployment($personId);
    }



    public function processEndEmployment ($employmentId)
    {
        return $this->endEmployment($employmentId);
    }

}
