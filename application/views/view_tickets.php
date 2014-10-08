<?php

class view_tickets {

    private $ticketPriorityLevel;
    private $ticketSource;
    private $ticketHelpTopic;

    public function __construct () {
        $fx = new myFunctions();
        $this->ticketPriorityLevel = $fx->enumSelectOptions(
            'ticket_tickets'
            ,'ticket_priority_level');
        $this->ticketSource = $fx->enumSelectOptions(
            'ticket_tickets'
            ,'ticket_source');
        $this->ticketHelpTopic = $fx->enumSelectOptions(
            'ticket_tickets'
            ,'ticket_help_topic');
    }



    public function __destruct () {

    }



    public function ticketForm ($datas=null) {
        $fx = new myFunctions();
        $f = new form(array(
            'auto_line_break' => true
            ,'auto_label' => true));

        if ($datas === null) {
            $formType = 'New Ticket';
            $submitValue = 'Create Ticket';
        } else {
            $formType = 'Update Ticket';
            $submitValue = 'Update Ticket';
        }

        $fieldset = array(
            'ticketInformation' => '<span class="column">'
                .$f->checkbox(array(
                    'id' => 'ticket-send-notice-to-client'
                    ,'label' => 'Send Notice to Client'))
                .$f->text(array(
                    'id' => 'ticket-client'
                    ,'label' => 'Client'))
                .$f->text(array(
                    'id' => 'ticket-concerned-item'
                    ,'label' => 'Item'))
                .$f->select(array(
                    'id' => 'ticket-source'
                    ,'label' => 'Source'
                    ,'select_options' => $this->ticketSource))
                .$f->select(array(
                    'id' => 'ticket-department'
                    ,'label' => 'Department'
                    ,'select_options' => $fx->tableSelectOptions('imts_departments', 'department_id', 'department_name')))
                .$f->select(array(
                    'id' => 'ticket-help-topic'
                    ,'label' => 'Help Topic'
                    ,'select_options' => $this->ticketHelpTopic))
                .$f->text(array(
                    'id' => 'ticket-date-due'
                    ,'class' => 'datepicker'
                    ,'label' => 'Due Date'))
                .$f->text(array(
                    'id' => 'ticket-staff-assigned'
                    ,'label' => 'Assigned Staff'))
                .$f->select(array(
                    'id' => 'ticket-priority-level'
                    ,'label' => 'Priority Level'
                    ,'select_options' => $this->ticketPriorityLevel))
                .'</span>'

            ,'ticketDetails' => '<span class="column">'
                .$f->text(array(
                    'id' => 'ticket-subject'
                    ,'label' => 'Subject'
                    ,'placeholder' => 'Main Issue'))
                .$f->textarea(array(
                    'id' => 'ticket-summary'
                    ,'class' => 'long'
                    ,'label' => 'Summary'
                    ,'placeholder' => 'Place here the summary of your ticket / issue...'))
                .$f->textarea(array(
                    'id' => 'ticket-initial-response'
                    ,'class' => 'long'
                    ,'label' => 'Initial Response'
                    ,'placeholder' => 'Initial Response for the ticket...'))
                .$f->textarea(array(
                    'id' => 'ticket-internal-note'
                    ,'class' => 'long'
                    ,'label' => 'Internal Note'
                    ,'placeholder' => 'Optional internal note, recommended on assignment...'))
                .'</span>');

        $fieldsetPresentation = $fieldset['ticketInformation']
            .$fieldset['ticketDetails'];

        $output = '<span class="form-header">'.$formType.'</span>
            <div class="hr"></div>'
            .$f->openForm(array(
                'id' => 'form-create-ticket'
                ,'method' => 'post'
                ,'action' => ''
                ,'enctype' => 'multipart/form-data'))
            .$fieldsetPresentation
            .'<div class="hr-light"></div>'
            .$f->submit(array('value' => $submitValue))
            .$f->closeForm();
        return $output;
    }

}
