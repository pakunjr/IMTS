<?php

class model_items {

    private $db;

    public function __construct () {
        $this->db = new database();
    }



    public function __destruct () {

    }



    public function createItem ($datas) {
        $d = array_map('trim', $datas);
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
                ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)"
            ,'v'=>array(
                $d['item-name']
                ,$d['item-serial-no']
                ,$d['item-model-no']
                ,$d['item-type']
                ,$d['item-state']
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
            $this->logAction($d['item-id'], 'Item Creation: SUCCESS');
            return $d;
        } else
            return null;
    }



    public function createItemOwnership ($datas) {
        $d = array_map('trim', $datas);
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
        
        if ($ownership) {
            $d['ownership-id'] = $this->db->lastInsertId();
            return $d;
        } else
            return null;
    }



    public function createMultipleItems ($datas) {
        if ($datas == null)
            return null;

        $d = $datas;
        $c_errors = new controller_errors();

        $ownerDatas = array(
            'ownership-owner'=>$d['ownership-owner']
            ,'ownership-owner-type'=>$d['ownership-owner-type']
            ,'ownership-date-owned'=>$d['ownership-date-owned']
            ,'ownership-date-released'=>$d['ownership-date-released']);
        unset($d['ownership-owner']);
        unset($d['ownership-owner-label']);
        unset($d['ownership-owner-type']);
        unset($d['ownership-date-owned']);
        unset($d['ownership-date-released']);

        $mainItemDatas = array(
            'item-name'=>$d['item-name']
            ,'item-serial-no'=>$d['item-serial-no']
            ,'item-model-no'=>$d['item-model-no']
            ,'item-type'=>$d['item-type']
            ,'item-state'=>$d['item-state']
            ,'item-description'=>$d['item-description']
            ,'item-quantity'=>$d['item-quantity']
            ,'item-date-of-purchase'=>$d['item-date-of-purchase']
            ,'item-package'=>$d['item-package']
            ,'item-cost'=>$d['item-cost']
            ,'item-depreciation'=>$d['item-depreciation']
            ,'item-has-components'=>1
            ,'item-component-of'=>0);
        unset($d['item-name']);
        unset($d['item-serial-no']);
        unset($d['item-model-no']);
        unset($d['item-type']);
        unset($d['item-state']);
        unset($d['item-description']);
        unset($d['item-quantity']);
        unset($d['item-date-of-purchase']);
        unset($d['item-package']);
        unset($d['item-package-label']);
        unset($d['item-cost']);
        unset($d['item-depreciation']);

        $componentTypes = trim($d['item-components-types'], '/');
        $componentTypes = strtolower($componentTypes);
        $componentTypes = str_replace(' ', '-', $componentTypes);
        $componentTypes = explode('/', $componentTypes);
        unset($d['item-components-types']);

        $mainItemSaveResult = $this->createItem($mainItemDatas);
        if ($mainItemSaveResult != null) {
            $mainItem = $mainItemSaveResult;
            if ($ownerDatas['ownership-owner'] != 0) {
                $ownerDatas['item-id'] = $mainItem['item-id'];
                $ownershipSaveResult = $this->createItemOwnership($ownerData);
            }

            // Distinguish components individually
            $components = array();
            foreach ($componentTypes as $c) {
                $sameTypeItems = array();
                foreach ($d['item-name-'.$c] as $i=>$v) {
                    $sameTypeItems[$i]['item-name'] = $v;
                }
                foreach ($d['item-serial-no-'.$c] as $i=>$v) {
                    $sameTypeItems[$i]['item-serial-no'] = $v;
                }
                foreach ($d['item-model-no-'.$c] as $i=>$v) {
                    $sameTypeItems[$i]['item-model-no'] = $v;
                }
                foreach ($d['item-description-'.$c] as $i=>$v) {
                    $sameTypeItems[$i]['item-description'] = $v;
                }
                foreach ($d['item-quantity-'.$c] as $i=>$v) {
                    $sameTypeItems[$i]['item-quantity'] = $v;
                }
                foreach ($d['item-date-of-purchase-'.$c] as $i=>$v) {
                    $sameTypeItems[$i]['item-date-of-purchase'] = $v;
                }
                foreach ($d['item-state-'.$c] as $i=>$v) {
                    $sameTypeItems[$i]['item-state'] = $v;
                }
                foreach ($d['item-cost-'.$c] as $i=>$v) {
                    $sameTypeItems[$i]['item-cost'] = $v;
                }
                foreach ($d['item-depreciation-'.$c] as $i=>$v) {
                    $sameTypeItems[$i]['item-depreciation'] = $v;
                }

                foreach ($sameTypeItems as $sti) {
                    if (strlen($sti['item-name']) > 0
                            || strlen($sti['item-serial-no']) > 0
                            || strlen($sti['item-model-no']) > 0) {
                        $sti['item-type'] = $mainItem['item-type'];
                        $sti['item-package'] = $mainItem['item-package'];
                        $sti['item-has-components'] = 0;
                        $sti['item-component-of'] = $mainItem['item-id'];
                        array_push($components, $sti);
                    }
                }
            }

            // Save each item individually and
            // appoint ownership respectively
            foreach ($components as $c) {
                $componentSaveResult = $this->createItem($c);
                if ($componentSaveResult != null) {
                    if ($ownerDatas['ownership-owner'] != 0) {
                        $ownerDatas['item-id'] = $componentSaveResult['item-id'];
                        $this->createItemOwnership($ownerDatas);
                    }
                } else {
                    $c_errors->logError('Failed to save the component.');
                }
            }
            return $mainItem;
        } else {
            $c_errors->logError('Form for multiple item input can\'t save the main item.');
        }
    }



    public function readItem ($itemId) {
        $r = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items
                WHERE item_id = ?
                LIMIT 1"
            ,'v'=>array(
                intval($itemId))));
        return count($r) > 0 ? $r[0] : null;
    }



    public function readItemComponents ($itemId) {
        $r = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_items
                WHERE item_component_of = ? 
                ORDER BY
                    item_archive_state ASC
                    ,item_type ASC
                    ,item_state ASC
                    ,item_component_of ASC
                    ,item_name ASC
                    ,item_serial_no ASC
                    ,item_model_no ASC"
            ,'v'=>array(intval($itemId))));
        return count($r) > 0 ? $r : null;
    }



    public function readItemOwner ($itemId) {
        $currentDate = date('Y-m-d');
        $r = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership
                WHERE
                    ownership_item = ?
                    AND (
                        ownership_date_released = '0000-00-00'
                        OR ownership_date_released > '$currentDate')
                LIMIT 1"
            ,'v'=>array(
                intval($itemId))));
        return count($r) > 0 ? $r[0] : null;
    }



    public function readItemOwners ($itemId) {
        $r = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership
                WHERE ownership_item = ?
                ORDER BY
                    FIELD(ownership_date_released, '0000-00-00') DESC
                    ,ownership_date_released DESC"
            ,'v'=>array(
                intval($itemId))));
        return count($r) > 0 ? $r : null;
    }



    public function updateItem ($datas) {
        $d = array_map('trim', $datas);
        $d['item-has-components'] = isset($d['item-has-components'])
            ? '1'
            : '0';
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
                ,$d['item-type']
                ,$d['item-state']
                ,$d['item-description']
                ,$d['item-quantity']
                ,$d['item-date-of-purchase']
                ,intval($d['item-package'])
                ,$d['item-cost']
                ,$d['item-depreciation']
                ,intval($d['item-has-components'])
                ,intval($d['item-component-of'])
                ,intval($d['item-id']))));

        if ($r)
            $this->logAction($d['item-id'], 'Update: SUCCESS');
        else
            $this->logAction($d['item-id'], 'Update: FAILED');
        
        return $d;
    }



    public function updateItemOwnership ($datas) {
        $d = array_map('trim', $datas);
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

        if ($ownership)
            $this->logAction($d['item-id'], 'Current Owner Update alongside Item Update: SUCCESS');
        else
            $this->logAction($d['item-id'], 'Current Owner Update alongside Item Update: FAILED');
    }



    public function deleteItem ($itemId) {
        // Delete item from the database
        $result = $this->db->statement(array(
            'q'=>"DELETE FROM imts_items WHERE item_id = ?"
            ,'v'=>array(
                intval($itemId))));

        if ($result) {
            // Do not delete the components but
            // change their host item
            $this->db->statement(array(
                'q'=>"UPDATE imts_items
                    SET item_component_of = 0
                    WHERE item_component_of = ?"
                ,'v'=>array(
                    intval($itemId))));

            // Delete all ownerships of the items
            $this->db->statement(array(
                'q'=>"DELETE FROM imts_ownership WHERE ownership_item = ?"
                ,'v'=>array(
                    intval($itemId))));

            return true;
        } else
            return false;
    }



    public function deleteItemOwnership ($ownershipId) {
        $currentDate = date('Y-m-d');
        $result = $this->db->statement(array(
            'q'=>"UPDATE imts_ownership
                SET ownership_date_released = '$currentDate'
                WHERE ownership_id = ?"
            ,'v'=>array(intval($ownershipId))));
        return $result;
    }



    public function archiveItem ($itemId) {
        $result = $this->db->statement(array(
            'q'=>"UPDATE imts_items
                SET item_archive_state = 1
                WHERE item_id = ?"
            ,'v'=>array(
                intval($itemId))));
        return $result;
    }



    public function searchItems ($searchType='items', $keyword) {
        $fx = new myFunctions();

        switch ($searchType) {
            case 'items':
                $addCondArchiveState = !$fx->isAccessible('Supervisor')
                    ? "AND item.item_archive_state = 0"
                    : '';
                $whereClause = "WHERE
                    (item.item_name LIKE ?
                        OR item.item_serial_no LIKE ?
                        OR item.item_model_no LIKE ?)
                    $addCondArchiveState";
                break;

            case 'componentHosts':
                $whereClause = "WHERE
                    item.item_has_components = 1
                    AND item.item_archive_state = 0
                    AND (item.item_name LIKE ?
                        OR item.item_serial_no LIKE ?
                        OR item.item_model_no LIKE ?)";
                break;

            default:
                $whereClause = null;
        }

        if ($whereClause != null) {
            $rows = $this->db->statement(array(
                'q'=>"SELECT * FROM imts_items AS item
                    LEFT JOIN imts_items_package AS package ON item.item_package = package.package_id
                    $whereClause
                    ORDER BY
                        item.item_component_of ASC
                        ,item.item_name ASC
                        ,item.item_serial_no ASC
                        ,item.item_model_no ASC"
                ,'v'=>array(
                    "%$keyword%"
                    ,"%$keyword%"
                    ,"%$keyword%")));
        } else
            $rows = array();
        return count($rows) > 0 ? $rows : null;
    }



    public function fetchInventory ($ownerType, $ownerId) {
        $datas = $this->db->statement(array(
            'q'=>"SELECT * FROM imts_ownership AS own
                LEFT JOIN imts_items AS item ON own.ownership_item = item.item_id
                WHERE
                    own.ownership_owner_type = ?
                    AND own.ownership_owner = ?
                ORDER BY
                    item.item_component_of ASC
                    ,FIELD(item.item_state, 'Working', 'Stored', 'Broken', 'Disposed')
                    ,item.item_name ASC
                    ,item.item_serial_no ASC
                    ,item.item_model_no ASC"
            ,'v'=>array(
                $ownerType
                ,intval($ownerId))));
        return count($datas) > 0 ? $datas : null;
    }



    public function logAction ($itemId, $logContent) {
        $item = $this->readItem($itemId);
        $log = unserialize($item['item_log']);
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
            if ($rows[0]['item_has_components'] == 1)
                return true;
            else
                return false;
        } else
            return null;
    }
    
}
