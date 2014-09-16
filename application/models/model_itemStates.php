<?php

class model_itemStates {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

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
