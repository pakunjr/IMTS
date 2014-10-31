<?php

class Tickets extends Database
{

    public function __construct ()
    {
        parent::__construct();
    }



    public function __destruct ()
    {

    }



    protected function createTicket ($datas)
    {

    }



    protected function readTicket ($ticketId)
    {
        $query = "SELECT * FROM ticket_tickets
            WHERE ticket_id = ?
            LIMIT 1";
        $values = array(intval($ticketId));
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function updateTicket ($datas, $ticketId)
    {

    }



    protected function deleteTicket ($ticketId)
    {
        $query = "DELETE FROM ticket_tickets
            WHERE ticket_id = ?";
        $values = array(intval($ticketId));
        $result = $this->statement($query, $values);
        if ($result === true) {
            $query = "DELETE FROM ticket_responses
                WHERE response_ticket = ?";
            $values = array(intval($ticketId));
            $deleteResult = $this->statement($query, $values);
        }
        return $result;
    }



    protected function openTicket ($ticketId)
    {
        $query = "UPDATE ticket_tickets
            SET ticket_status = ?
            WHERE ticket_id = ?";
        $values = array('Open', intval($ticketId));
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function closeTicket ($ticketId)
    {
        $query = "UPDATE ticket_tickets
            SET ticket_status = ?
            WHERE ticket_id = ?";
        $values = array('Closed', intval($ticketId));
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function createResponse ($ticketId, $contents)
    {
        $query = "INSERT INTO ticket_responses(
                response_ticket,
                response_submitted_by,
                response_date_submitted,
                response_content
            ) VALUES(?,?,?,?)";
        $values = array(
                intval($ticketId),
                $_SESSION['personId'],
                date('Y-m-d H:i:s'),
                $contents
            );
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function readResponse ($responseId)
    {
        $query = "SELECT * FROM ticket_responses
            WHERE response_id = ?
            LIMIT 1";
        $values = array(intval($responseId));
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function readResponses ($ticketId)
    {
        $query ="SELECT * FROM ticket_responses
            WHERE response_ticket = ?";
        $values = array(intval($ticketId));
        $results = $this->statement($query, $values);
        return $results;
    }



    protected function updateResponse ($contents, $responseId)
    {
        $query = "UPDATE ticket_responses
            SET
                response_date_submitted = ?,
                response_content = ?
            WHERE response_id = ?";
        $values = array(
                date('Y-m-d H:i:s'),
                $contents,
                intval($responseId)
            );
        $result = $this->statement($query, $values);
        return $result;
    }



    protected function deleteResponse ($responseId)
    {
        $query = "DELETE FROM ticket_responses
            WHERE response_id = ?";
        $values = array(intval($responseId));
        $result = $this->statement($query, $result);
        return $result;
    }

}
