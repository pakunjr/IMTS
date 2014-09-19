<?php

class model_inventory {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function fetchInventory ($ownerType, $ownerId) {
        $datas = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership AS own
                LEFT JOIN imts_items AS item ON own.ownership_item = item.item_id
                LEFT JOIN imts_items_type AS iType ON item.item_type = iType.item_type_id
                LEFT JOIN imts_items_state AS iState ON item.item_state = iState.item_state_id
                WHERE
                    own.ownership_owner_type = ?
                    AND own.ownership_owner = ?
                ORDER BY
                    item.item_component_of ASC
                    ,FIELD(iState.item_state_label, 'Working', 'Stored', 'Broken', 'Disposed')
                    ,item.item_name ASC
                    ,item.item_serial_no ASC
                    ,item.item_model_no ASC"
            ,'v'=>array(
                $ownerType
                ,intval($ownerId))));
        return count($datas) > 0 ? $datas : null;
    }

}
