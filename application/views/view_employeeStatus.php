<?php

class view_employeeStatus {

    public function renderSelectForm ($datas, $options) {
        $f = new form(array(
                'auto_line_break'=>isset($options['auto_line_break']) ? $options['auto_line_break'] : true
                ,'auto_label'=>isset($options['auto_label']) ? $options['auto_label'] : true));
        $selectOptions = $f->generate(array(
            'type'=>'select_options'
            ,'datas'=>$datas
            ,'label'=>'employee_status_label'
            ,'value'=>'employee_status_id'));
        
        $output = $f->select(array(
            'id'=>'employee-status'
            ,'label'=>isset($options['label']) ? $options['label'] : 'Status'
            ,'select_options'=>$selectOptions
            ,'default_option'=>isset($options['default_option']) ? $options['default_option'] : ''));
        return $output;
    }

}
