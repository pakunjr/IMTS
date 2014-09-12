<?php

class model_items {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function createItem ($datas) {
        $d = $datas;
        $d['item-has-components'] = isset($d['item-has-components']) ? '1' : '0';

        $res = $this->db->statement(array(
            'q'=>"INSERT INTO imts_items(
                    item_name
                    ,item_serial_no
                    ,item_model_no
                    ,item_type
                    ,item_state
                    ,item_description
                    ,item_quantity
                    ,item_date_of_purchase
                    ,item_package
                    ,item_cost
                    ,item_depreciation
                    ,item_has_components
                    ,item_component_of
                ) VALUES(?,?,?,?,?,?,?,?,?,?,?)"
            ,'v'=>array(
                $d['item-name']
                ,$d['item-serial-no']
                ,$d['item-model-no']
                ,intval($d['item-type'])
                ,intval($d['item-state'])
                ,$d['item-description']
                ,$d['item-quantity']
                ,$d['item-date-of-purchase']
                ,intval($d['item-package'])
                ,$d['item-cost']
                ,$d['item-depreciation']
                ,intval($d['item-has-components'])
                ,intval($d['item-component-of']))));
        if ($res) {
            $d['item-id'] = $this->db->lastInsertId();
            $this->logAction($d['item-id'], 'This item was created.');
            return $d;
        } else return null;
    }



    public function createItemOwnership ($datas) {
        $d = $datas;
        $ownership = $this->db->statement(array(
            'q'=>"INSERT INTO imts_ownership(
                    ownership_item
                    ,ownership_owner
                    ,ownership_owner_type
                    ,ownership_date_owned
                    ,ownership_date_released
                ) VALUES(?,?,?,?,?)"
            ,'v'=>array(
                intval($d['item-id'])
                ,intval($d['ownership-owner'])
                ,$d['ownership-owner-type']
                ,$d['ownership-date-owned']
                ,$d['ownership-date-released'])));
        
        if ($ownership) $this->logAction($d['item-id'], 'Successfully created an ownership for this item.');
        else $this->logAction($d['item-id'], 'Failed to create an ownership for this item.');
    }



    public function readItem ($itemId) {
        $r = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items WHERE item_id = ? LIMIT 1"
            ,'v'=>array(
                intval($itemId))));
        return count($r) > 0 ? $r[0] : null;
    }



    public function readItemComponents ($itemId) {
        $r = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items WHERE item_component_of = ? 
                ORDER BY
                    item_archive_state ASC
                    ,item_type ASC
                    ,item_state ASC
                    ,item_name ASC
                    ,item_serial_no ASC
                    ,item_model_no ASC"
            ,'v'=>array(intval($itemId))));
        return count($r) > 0 ? $r : null;
    }



    public function readItemOwner ($itemId) {
        $currentDate = date('Y-m-d');
        $r = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership WHERE ownership_item = ? AND (ownership_date_released = '0000-00-00' OR ownership_date_released > '$currentDate') LIMIT 1"
            ,'v'=>array(
                intval($itemId))));
        return count($r) > 0 ? $r[0] : null;
    }



    public function readItemOwners ($itemId) {
        $r = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership WHERE ownership_item = ? ORDER BY
                    FIELD(ownership_date_released, '0000-00-00') DESC
                    ,ownership_date_released DESC"
            ,'v'=>array(
                intval($itemId))));
        return count($r) > 0 ? $r : null;
    }



    public function updateItem ($datas) {
        $d = $datas;
        $d['item-has-components'] = isset($d['item-has-components']) ? '1' : '0';
        $r = $this->db->statement(array(
            'q'=>"UPDATE imts_items
                SET
                    item_name = ?
                    ,item_serial_no = ?
                    ,item_model_no = ?
                    ,item_type = ?
                    ,item_state = ?
                    ,item_description = ?
                    ,item_quantity = ?
                    ,item_date_of_purchase = ?
                    ,item_package = ?
                    ,item_cost = ?
                    ,item_depreciation = ?
                    ,item_has_components = ?
                    ,item_component_of = ?
                WHERE item_id = ?"
            ,'v'=>array(
                $d['item-name']
                ,$d['item-serial-no']
                ,$d['item-model-no']
                ,intval($d['item-type'])
                ,intval($d['item-state'])
                ,$d['item-description']
                ,$d['item-quantity']
                ,$d['item-date-of-purchase']
                ,intval($d['item-package'])
                ,$d['item-cost']
                ,$d['item-depreciation']
                ,intval($d['item-has-components'])
                ,intval($d['item-component-of'])
                ,intval($d['item-id']))));

        if ($r) $this->logAction($d['item-id'], 'This item has been updated.');
        else $this->logAction($d['item-id'], 'Something went wrong when updating this item.');
        
        return $d;
    }



    public function updateItemOwnership ($datas) {
        $d = $datas;
        $ownership = $this->db->statement(array(
            'q'=>"UPDATE imts_ownership
                SET
                    ownership_date_owned = ?
                    ,ownership_date_released = ?
                WHERE ownership_id = ?"
            ,'v'=>array(
                $d['ownership-date-owned']
                ,$d['ownership-date-released']
                ,intval($d['ownership-id']))));

        if ($ownership) $this->logAction($d['item-id'], 'The ownership of this item has been updated successfully.');
        else $this->logAction($d['item-id'], 'The ownership of this item have failed to be updated.');
    }



    public function archiveItem ($itemId) {
        $result = $this->db->statement(array(
            'q'=>"UPDATE imts_items SET item_archive_state = 1 WHERE item_id = ?"
            ,'v'=>array(
                intval($itemId))));
        return $result;
    }



    public function deleteItemOwnership ($ownershipId) {
        $currentDate = date('Y-m-d');
        $result = $this->db->statement(array(
            'q'=>"UPDATE imts_ownership SET ownership_date_released = '$currentDate' WHERE ownership_id = ?"
            ,'v'=>array(intval($ownershipId))));
        return $result;
    }



    public function searchItems ($searchType='items', $keyword) {
        switch ($searchType) {
            case 'items':
                $rows = $this->db->statement(array(
                    'q'=>"SELECT * FROM imts_items
                        WHERE
                            item_name LIKE ?
                            OR item_serial_no LIKE ?
                            OR item_model_no LIKE ?
                        ORDER BY
                            item_archive_state ASC"
                    ,'v'=>array(
                        "%$keyword%"
                        ,"%$keyword%"
                        ,"%$keyword%")));
                break;

            case 'componentHosts':
                $rows = $this->db->statement(array(
                    'q'=>"SELECT * FROM imts_items
                        WHERE
                            item_has_components = 1
                            AND item_archive_state = 0
                            AND (
                                item_name LIKE ?
                                OR item_serial_no LIKE ?
                                OR item_model_no LIKE ?)
                        ORDER BY
                            LENGTH(item_name) ASC
                            ,item_name ASC"
                    ,'v'=>array(
                        "%$keyword%"
                        ,"%$keyword%"
                        ,"%$keyword%")));
                break;

            default:
                $rows = array();
        }
        return count($rows) > 0 ? $rows : null;
    }



    public function logAction ($itemId, $logContent) {
        $item = $this->readItem($itemId);
        $log = $item['item_log'];
        $log = unserialize($log);
        $log = is_array($log) ? $log : array();

        array_push($log, array(
            'date'=>date('Y-m-d')
            ,'time'=>date('H:i:s')
            ,'user'=>$_SESSION['user']['username'].' -- '.$_SESSION['user']['name']
            ,'log'=>$logContent));

        $log = serialize($log);

        $this->db->statement(array(
            'q'=>"UPDATE imts_items SET item_log = '$log' WHERE item_id = $itemId"));
    }



    public function isItemComponentHost ($itemId) {
        $rows = $this->db->statement(array(
            'q'=>"SELECT item_has_components FROM imts_items WHERE item_id = ?"
            ,'v'=>array(
                intval($itemId))));
        if (count($rows) > 0) {
            if ($rows[0]['item_has_components'] == 1) return true;
            else return false;
        } else return null;
    }
    
}
