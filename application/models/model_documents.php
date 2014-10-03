<?php

class model_documents {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function profileCard ($itemId) {
        /**
         * Get informations for generating the
         * item's profile card
         */
        $result = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items AS item
                LEFT JOIN imts_items_package AS iPackage ON item.item_package = iPackage.package_id
                WHERE
                    (item.item_id = ?
                        OR item.item_component_of = ?)
                    AND item.item_state = 'Working'
                ORDER BY
                    item.item_component_of ASC
                    ,item.item_type ASC
                    ,item.item_name ASC
                    ,item.item_serial_no ASC
                    ,item.item_model_no ASC"
            ,'v'=>array(
                intval($itemId)
                ,intval($itemId))));
        if (count($result) > 0) {
            $result['item_id'] = $result[0]['item_id'];
            $result['item_name'] = $result[0]['item_name'];
            return $result;
        } else
            return null;
    }



    public function ownerInventory ($ownerType, $ownerId) {
        /**
         * Get the item lists that is
         * owned by a specific owner,
         * either a department or a
         * person
         */
        $result = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership AS own
                LEFT JOIN imts_items AS item ON own.ownership_item = item.item_id
                WHERE ownership_owner_type = ?
                    AND ownership_owner = ?
                ORDER BY
                    item.item_component_of ASC
                    ,FIELD(item.item_state, 'Working', 'Broken', 'Stored', 'Disposed')
                    ,item.item_name ASC
                    ,item.item_serial_no
                    ,item.item_model_no"
            ,'v'=>array(
                $ownerType
                ,intval($ownerId))));
        if (count($result) > 0) {
            /**
             * The sample ownership id will be used
             * by the output renderer to identify the
             * owner name
             */
            $result['ownership_id'] = $result[0]['ownership_id'];
            return $result;
        } else
            return null;
    }



    public function traceItem ($itemId) {
        /**
         * Get the following information
         * of the item:
         * - Ownership History
         * - Maintenance History
         */
    }
    
}
