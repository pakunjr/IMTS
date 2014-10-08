<?php

class controller_tickets {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_tickets();
        $this->view = new view_tickets();
    }



    public function __destruct () {

    }



    public function ticketForm ($ticketId=null) {
        if ($ticketId === null)
            $datas = $this->model->readTicket($ticketId);
        else
            $datas = null;

        echo $this->view->ticketForm($datas);
    }



    public function saveTicketForm () {
        $c_pages = new controller_pages();

        if (!isset($_POST) || count($_POST) < 1) {
            $msg = 'The server is redirecting you to another page so you can validly create a new ticket.';
            $url = URL_BASE.'tickets/new_ticket/';
            $c_pages->pageRedirect($msg, $url);
        }
    }

}
