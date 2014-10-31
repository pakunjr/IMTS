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
            Accounts<div class="hr-light"></div>
            <a class="button" href="'.URL_BASE.'accounts/registration/">Register an account</a><br />
            <a class="button" href="'.URL_BASE.'accounts/check_accounts/">Check registered accounts</a>
            </div>';
        return $html;
    }

}
