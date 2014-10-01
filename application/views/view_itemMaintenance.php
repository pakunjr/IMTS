<?php

class view_itemMaintenance {

    public function __construct () {

    }



    public function __destruct () {

    }



    public function formItemMaintenance ($options=array()) {
        $f = new form(array(
            'auto_line_break' => true
            ,'auto_label' => true));
        $fx = new myFunctions();
        $c_items = new controller_items();

        $datas = isset($options['datas'])
            ? $options['datas']
            : null;

        $formAction = $datas === null
            ? URL_BASE.'inventory_maintenance/create_maintenance/save/'
            : URL_BASE.'inventory_maintenance/update_maintenance/save/';

        $itemId = isset($options['itemId'])
            ? $options['itemId']
            : 0;

        $o = $f->openForm(array(
                'id' => 'form-item-maintenance'
                ,'method' => 'post'
                ,'action' => $formAction
                ,'enctype' => 'multipart/form-data')).'
            '.$f->openFieldset(array(
                'legend' => 'Maintenance Information')).'
            <span class="column">
            '.$f->hidden(array(
                'id' => 'maintenance-item'
                ,'data-url' => URL_BASE.'inventory/in_search_item/'
                ,'value' => $datas !== null
                    ? $datas['maintenance_item']
                    : $itemId)).'
            '.$f->text(array(
                'id' => 'maintenance-item-label'
                ,'label' => 'Item'
                ,'value' => $datas !== null
                    ? $c_items->displayItemName(
                        $datas['maintenance_item']
                        ,false)
                    : $c_items->displayItemName(
                        $itemId
                        ,false))).'
            '.$f->hidden(array(
                'id' => 'maintenance-assigned-staff'
                ,'data-url' => URL_BASE.'persons/in_search_person/'
                ,'value' => isset($_SESSION['user'])
                    ? $_SESSION['user']['personId']
                    : 0)).'
            '.$f->text(array(
                'id' => 'maintenance-assigned-staff-label'
                ,'label' => 'Assigned Staff'
                ,'value' => isset($_SESSION['user'])
                    ? $_SESSION['user']['name']
                    : 'None')).'
            '.$f->select(array(
                'id' => 'maintenance-status'
                ,'label' => 'Status')).'
            </span>
            <span class="column">
            '.$f->textarea(array(
                'id' => 'maintenance-detailed-report'
                ,'label' => 'Detailed Report')).'
            </span>
            '.$f->closeFieldset().'
            '.$f->submit(array('value' => 'Save Maintenance')).'
            '.$f->closeForm();
        return $o;
    }
    
}
