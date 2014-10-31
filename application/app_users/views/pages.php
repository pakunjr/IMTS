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

}
