<?php

class model_itemStates {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function createSelectOptions () {
        $states = $this->readItemStates();
        if (is_array($states)) {
            $selectOptions = array();
            foreach ($states as $s) {
                $label = $s['item_state_label'];
                $value = $s['item_state_id'];
                $selectOptions[$label] = $value;
            }
            return $selectOptions;
        } else
            return null;
    }



    public function readItemState ($stateId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_state WHERE item_state_id = ? LIMIT 1"
            ,'v'=>array(
                intval($stateId))));
        return count($rows) > 0 ? $rows[0] : null;
    }


    
    public function readItemStates () {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_state"));
        return count($rows) > 0 ? $rows : null;
    }

}
