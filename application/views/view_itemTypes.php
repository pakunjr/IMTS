<?php

class view_itemTypes {

    public function renderSelectForm ($types, $options=array()) {
        $f = new form(array(
            'auto_line_break'=>isset($options['auto_line_break']) ? $options['auto_line_break'] : true
            ,'auto_label'=>isset($options['auto_label']) ? $options['auto_label'] : true));

        $select_options = $f->generate(array(
            'type'=>'select_options'
            ,'datas'=>$types
            ,'label'=>'item_type_label'
            ,'value'=>'item_type_id'));

        return $f->select(array(
            'id'=>'item-type'
            ,'label'=>isset($options['label']) ? $options['label'] : ''
            ,'select_options'=>$select_options
            ,'default_option'=>isset($options['default_option']) ? $options['default_option'] : ''));
    }



    public function renderItemTypeName ($itemType) {
        return $itemType != null ? $itemType['item_type_label'] : 'None';
    }

}
