<?php

class view_itemStates {

    public function __construct () {

    }



    public function __destruct () {

    }



    public function renderSelectForm ($states, $options=array()) {
        $f = new form(array(
            'auto_line_break'=>isset($options['auto_line_break']) ? $options['auto_line_break'] : true
            ,'auto_label'=>isset($options['auto_label']) ? $options['auto_label'] : true));

        $select_options = $f->generate(array(
            'type'=>'select_options'
            ,'datas'=>$states
            ,'label'=>'item_state_label'
            ,'value'=>'item_state_id'));

        return $f->select(array(
            'id'=>'item-state'
            ,'label'=>isset($options['label']) ? $options['label'] : ''
            ,'select_options'=>$select_options
            ,'default_option'=>isset($options['default_option']) ? $options['default_option'] : ''));
    }



    public function renderItemStateName ($itemState) {
        return $itemState != null ? $itemState['item_state_label'] : 'None';
    }

}
