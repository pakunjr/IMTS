<?php

class model_itemTypes {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function readItemType ($typeId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_type WHERE item_type_id = ? LIMIT 1"
            ,'v'=>array(
                intval($typeId))));
        return count($rows) > 0 ? $rows[0] : null;
    }



    public function readItemTypes () {
        $rows = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items_type"));
        return count($rows) > 0 ? $rows : null;
    }
    
}
