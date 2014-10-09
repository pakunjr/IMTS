<?php

class model_tickets {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function createTicket ($datas) {
        if (isset($datas['ticket-date-closed'])) {
            $datas['ticket-date-closed'] = date('Y-m-d H:i:s');
            $datas['ticket-status'] = 'Closed';
        } else {
            $datas['ticket-date-closed'] = '0000-00-00 00:00:00';
            $datas['ticket-status'] = 'Open';
        }

        $query = "INSERT INTO ticket_tickets(
                ticket_staff_assigned
                ,ticket_client
                ,ticket_item_concerned
                ,ticket_priority_level
                ,ticket_source
                ,ticket_status
                ,ticket_help_topic
                ,ticket_subject
                ,ticket_summary
                ,ticket_internal_note
                ,ticket_date_submitted
                ,ticket_date_due
                ,ticket_date_closed
            ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $values = array(
            intval($datas['ticket-staff-assigned'])
            ,intval($datas['ticket-client'])
            ,intval($datas['ticket-item-concerned'])
            ,$datas['ticket-priority-level']
            ,$datas['ticket-source']
            ,$datas['ticket-status']
            ,$datas['ticket-help-topic']
            ,$datas['ticket-subject']
            ,$datas['ticket-summary']
            ,$datas['ticket-internal-note']
            ,date('Y-m-d H:i:s')
            ,$datas['ticket-date-due']
            ,$datas['ticket-date-closed']);

        $status = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return $status;
    }



    public function readTicket ($ticketId) {
        $query = "SELECT * FROM ticket_tickets
            WHERE ticket_id = ?
            LIMIT 1";

        $values = array(
            intval($ticketId));

        $datas = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return count($datas) > 0 ? $datas[0] : null;
    }



    public function updateTicket ($datas) {
        if (isset($datas['ticket-date-closed'])) {
            $datas['ticket-date-closed'] = date('Y-m-d H:i:s');
            $datas['ticket-status'] = 'Closed';
        } else {
            $datas['ticket-date-closed'] = '0000-00-00 00:00:00';
            $datas['ticket-status'] = 'Open';
        }

        $query = "UPDATE ticket_tickets
            SET
                ticket_staff_assigned = ?
                ,ticket_client = ?
                ,ticket_item_concerned = ?
                ,ticket_priority_level = ?
                ,ticket_source = ?
                ,ticket_status = ?
                ,ticket_help_topic = ?
                ,ticket_subject = ?
                ,ticket_summary = ?
                ,ticket_internal_note = ?
                ,ticket_date_due = ?
                ,ticket_date_closed = ?
            WHERE ticket_id = ?";

        $values = array(
            intval($datas['ticket-staff-assigned'])
            ,intval($datas['ticket-client'])
            ,intval($datas['ticket-item-concerned'])
            ,$datas['ticket-priority-level']
            ,$datas['ticket-source']
            ,$datas['ticket-status']
            ,$datas['ticket-help-topic']
            ,$datas['ticket-subject']
            ,$datas['ticket-summary']
            ,$datas['ticket-internal-note']
            ,$datas['ticket-date-due']
            ,$datas['ticket-date-closed']
            ,intval($datas['ticket-id']));

        $status = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return $status;
    }



    public function deleteTicket ($ticketId) {
        $query = "DELETE FROM ticket_tickets
            WHERE ticket_id = ?";

        $values = array(
            intval($ticketId));

        $ticketStatus = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        if ($ticketStatus) {
            // Delete the responses if the
            // main ticket was sucessfully
            // deleted from the database
            $query = "DELETE FROM ticket_tickets_progress
                WHERE progress_ticket = ?";

            $values = array(
                intval($ticketId));

            $progressStatus = $this->db->statement(array(
                'q' => $query, 'v' => $values));

            return true;
        } else
            return false;
    }



    public function transferTicket ($ticketId, $personId) {
        $query = "UPDATE ticket_tickets
            SET ticket_staff_assigned = ?
            WHERE ticket_id = ?";

        $values = array(
            intval($personId)
            ,intval($ticketId));

        $status = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return $status;
    }



    public function openTicket ($ticketId) {
        $query = "UPDATE ticket_tickets
            SET
                ticket_date_closed = ?
                ,ticket_status = ?
            WHERE ticket_id = ?";

        $values = array(
            '0000-00-00'
            ,'Open'
            ,intval($ticketId));

        $status = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return $status;
    }



    public function closeTicket ($ticketId) {
        $query = "UPDATE ticket_tickets
            SET
                ticket_date_closed = ?
                ,ticket_status = ?
            WHERE ticket_id = ?";

        $values = array(
            date('Y-m-d')
            ,'Closed'
            ,intval($ticketId));

        $status = $this->db->statement(array(
            'q' => $query, 'v' => $values));

        return $status;
    }

}
