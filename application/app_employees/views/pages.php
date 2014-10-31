<?php

class ViewPages extends ModelPages
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {
        
    }



    public function renderHeader ()
    {
        $core = new SystemCore();
        return $core->renderThemeHeader();
    }



    public function renderFooter ()
    {
        $core = new SystemCore();
        return $core->renderThemeFooter();
    }



    protected function renderHomepage ()
    {
        $core = new SystemCore();
        $html = $core->renderPageTitle().
        '<div class="action-block">
        Employees
        <div class="hr-light"></div>
        <a class="button" href="'.URL_BASE.'employee/employee/registration/">Register an Employee</a><br />
        <a class="button" href="'.URL_BASE.'employee/employee/update/">Update Employee Information</a>
        </div>

        <div class="action-block">
        Employment
        <div class="hr-light"></div>
        <a class="button" href="'.URL_BASE.'employee/employment/update/">Update Employment</a><br />
        <a class="button" href="'.URL_BASE.'employee/employment/end/">End an Employment</a>
        </div>';
        return $html;
    }

}
