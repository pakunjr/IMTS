<?php

class controller_items {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_items();
        $this->view = new view_items();
    }



    public function __destruct () {

    }



    public function displayForm ($itemId=null, $niboti=null, $hostId=null) {
        if ($itemId != null) {
            $infos = array(
                'item'=>$this->model->readItem($itemId)
                ,'owner'=>$this->model->readItemOwner($itemId)
                ,'niboti'=>false
                ,'thruComponent'=>false);
        } else if ($hostId != null) {
            $hostDatas = $this->model->readItem($hostId);
            $hd = $hostDatas;
            $infos = array(
                'item'=>array(
                    'item_id'=>''
                    ,'item_name'=>''
                    ,'item_serial_no'=>''
                    ,'item_model_no'=>''
                    ,'item_type'=>''
                    ,'item_state'=>''
                    ,'item_description'=>''
                    ,'item_quantity'=>'1 pc.'
                    ,'item_date_of_purchase'=>$hd['item_date_of_purchase']
                    ,'item_package'=>$hd['item_package']
                    ,'item_archive_state'=>'0'
                    ,'item_has_components'=>'0'
                    ,'item_component_of'=>$hostId
                    ,'item_log'=>''
                    ,'item_cost'=>'0.00 PHP'
                    ,'item_depreciation'=>'UNDEFINED')
                ,'owner'=>$this->model->readItemOwner($hostId)
                ,'niboti'=>false
                ,'thruComponent'=>true);
        } else {
            $infos = array(
                'item'=>$niboti != null
                    ? $this->model->readItem($niboti)
                    : null
                ,'owner'=>$niboti != null
                    ? $this->model->readItemOwner($niboti)
                    : null
                ,'niboti'=>$niboti != null ? true : false
                ,'thruComponent'=>false);
        }

        echo $this->view->renderForm($infos);
    }



    public function displayFormMultipleItems () {
        echo $this->view->renderFormMultipleItems();
    }



    public function displayItem ($itemId=null) {
        if ($itemId != null) {
            $iData = $this->model->readItem($itemId);
            $iOwners = $this->model->readItemOwners($itemId);
            $iComponents = $this->model->readItemComponents($itemId);

            if ($iComponents != null) {
                foreach ($iComponents as $dc => $array) {
                    $currentOwner = $this->model->readItemOwner($array['item_id']);
                    $iComponents[$dc]['ownership'] = $currentOwner;
                }
            }

            $infos = array(
                'item'=>$iData
                ,'owners'=>$iOwners
                ,'components'=>$iComponents);
        } else {
            $infos = array(
                'item'=>null
                ,'owner'=>null
                ,'components'=>null);
        }

        echo $this->view->renderItemInformation($infos);
    }



    public function displayItemButtons ($itemId, $echo=true) {
        $output = $this->view->renderItemButtons($itemId);
        if (!$echo)
            return $output;
        echo $output;
    }



    public function displayInventory ($ownerType, $ownerId) {
        $datas = $this->model->fetchInventory($ownerType, $ownerId);
        echo $this->view->renderInventory($datas);
    }



    public function displayItemName ($itemId=null, $echo=true) {
        $item = $this->model->readItem($itemId);
        $itemName = $this->view->renderItemName($item);
        if (!$echo)
            return $itemName;
        echo $itemName;
    }



    public function displayItemCurrentOwner ($itemId, $echo=true) {
        $currentOwner = $this->model->readItemOwner($itemId);
        $output = $this->view->renderItemCurrentOwner($currentOwner);
        if (!$echo)
            return $output;
        echo $output;
    }



    public function displaySearchForm () {
        $keyword = isset($_POST['search-keyword']) ? $_POST['search-keyword'] : '';
        echo $this->view->renderSearchForm($keyword);
        $this->displaySearchResults('items', $keyword);
    }



    public function displaySearchResults ($searchType='items', $keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'Keywords can match the ff:<br /><br />'
                ,'Item Name<br />'
                ,'Item Serial No<br />'
                ,'Item Model No';
            return;
        }
        $keyword = trim($keyword);
        $results = $this->model->searchItems($searchType, $keyword);
        echo $this->view->renderSearchResults($results);
    }



    public function displayIsItemComponentHost ($itemId, $echo=true) {
        $isHost = $this->model->isItemComponentHost($itemId);
        $output = $isHost ? 'Yes' : 'No';
        if (!$echo)
            return $output;
        echo $output;
    }



    public function displayQrCode ($itemId, $echo=false) {
        $datas = $this->model->readItem($itemId);
        $output = $this->view->renderQrCode($datas);
        if (!$echo)
            return $output;
        echo $output;
    }



    public function saveItem () {
        $c_errors = new controller_errors();
        $c_pages = new controller_pages();

        if (isset($_POST)) {
            $datas = $this->model->createItem($_POST);
            $d = $datas;

            if ($d != null) {
                $currentOwner = $this->model->readItemOwner($d['item-id']);
                $co = $currentOwner;
                $c_owners = new controller_owners();

                if ($co != null) {
                    /**
                     * Check if ownership of the item
                     * is being change
                     */
                    if ($co['ownership_owner'] != $d['ownership-owner']) {
                        /**
                         * Remove ownership of the current
                         * owner and create ownership for
                         * the new owner if there is a new
                         * owner
                         */
                        $this->model->deleteItemOwnership($co['ownership_id']);

                        if ($d['ownership-owner'] != '0') {
                            $newItemOwnershipData = $this->model->createItemOwnership($d);
                            $niod = $newItemOwnershipData;
                            if ($niod != null)
                                $this->model->logAction($niod['item-id'], 'Changed ownership from `'.$c_owners->displayOwnerName($co['ownership_id'], false).'` to `'.$c_owners->displayOwnerName($niod['ownership-id'], false).'`');
                        } else
                            $this->model->logAction($d['item-id'], 'Removed ownership of `'.$c_owners->displayOwnerName($co['ownership_id'], false).'`');
                    }
                } else {
                    /**
                     * New ownership for item that is not
                     * owned
                     */
                    if ($d['ownership-owner'] != 0) {
                        $newItemOwnershipData = $this->model->createItemOwnership($d);
                        $niod = $newItemOwnershipData;
                        if ($niod != null)
                            $this->model->logAction($d['item-id'], 'Created new ownership for `'.$c_owners->displayOwnerName($niod['ownership-id'], false).'`');
                    }
                }
                $m = 'Item has been created successfully';
                $u = URL_BASE.'inventory/read_item/'.$d['item-id'].'/';
            } else {
                $c_errors->logError('System failed to save the new item.');
                $m = '<span style="color: #f00;">Error</span>: Failed to create the item.';
                $u = URL_BASE.'inventory/create_item/';
            }
        } else {
            $c_errors->logError('Save new item is being accessed directly without using the form, thus not passing any data.');
            $m = '<span style="color: #f00;">Error</span>: You can\'t access this page directly.';
            $u = URL_BASE.'inventory/create_item/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function saveMultipleItems () {
        $c_pages = new controller_pages();

        if (!isset($_POST)) {
            $m = '<span style="color: #f00;">Error</span>: You can\'t access this page directly.';
            $u = URL_BASE.'inventory/create_multiple_items/';
            $c_pages->pageRedirect($m, $u);
        }

        $result = $this->model->createMultipleItems($_POST);

        if ($result != null) {
            $m = 'Main item has been created successfully, please check the components if they\'re saved properly.';
            $u = URL_BASE.'inventory/read_item/'.$result['item-id'].'/';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Failed to create the item.';
            $u = URL_BASE.'inventory/create_multiple_items/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function updateItem () {
        $c_errors = new controller_errors();
        $c_pages = new controller_pages();

        if (isset($_POST)) {
            $datas = $this->model->updateItem($_POST);
            $d = $datas;
            if ($d != null) {
                $currentOwner = $this->model->readItemOwner($d['item-id']);
                $co = $currentOwner;
                $c_owners = new controller_owners();

                if ($co != null) {
                    /**
                     * Check if ownership of the item
                     * is being change
                     */
                    if ($co['ownership_owner'] != $d['ownership-owner']) {
                        /**
                         * Remove ownership of the current
                         * owner and create ownership for
                         * the new owner if there is a new
                         * owner
                         */
                        $this->model->deleteItemOwnership($co['ownership_id']);
                        if ($d['ownership-owner'] != '0') {
                            $newItemOwnershipData = $this->model->createItemOwnership($d);
                            $niod = $newItemOwnershipData;
                            if ($niod != null)
                                $this->model->logAction($niod['item-id'], 'Changed ownership from `'.$c_owners->displayOwnerName($co['ownership_id'], false).'` to `'.$c_owners->displayOwnerName($niod['ownership-id'], false).'`');
                        } else
                            $this->model->logAction($d['item-id'], 'Removed ownership of `'.$c_owners->displayOwnerName($co['ownership_id'], false).'`');
                    } else {
                        /**
                         * If there is no new owner, update
                         * the current owner
                         */
                        $this->model->updateItemOwnership($d);
                    }
                } else {
                    /**
                     * New ownership for item that is not
                     * owned
                     */
                    if ($d['ownership-owner'] != 0) {
                        $newItemOwnershipData = $this->model->createItemOwnership($d);
                        $niod = $newItemOwnershipData;
                        if ($niod != null)
                            $this->model->logAction($d['item-id'], 'Created new ownership for `'.$c_owners->displayOwnerName($niod['ownership-id'], false).'`');
                    }
                }

                $m = 'Updated the item successfully.<br />
                    Please double check for errors.';
            } else {
                $c_errors->logError('System failed to update the item.');
                $m = '<span style="color: #f00;">Error</span>: Failed to update the item.';
            }

            $u = URL_BASE.'inventory/read_item/'.$d['item-id'].'/';
            $c_pages->pageRedirect($m, $u);

        } else {
            $c_errors->logError('Update item is being accessed directly without using the form, thus not passing any data.');
            $m = '<span style="color: #f00;">Error</span>: You can\'t access this page directly.';
            $u = URL_BASE.'inventory/create_item/';
            $c_pages->pageRedirect($m, $u);
        }
    }



    public function deleteItem ($itemId) {
        $c_pages = new controller_pages();
        $result = $this->model->deleteItem($itemId);

        if ($result) {
            $m = 'Item has been deleted successfully.';
            $u = URL_BASE.'inventory/';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Item failed to be deleted.';
            $u = URL_BASE.'inventory/read_item/'.$itemId.'/';
        }

        $c_pages->pageRedirect($m, $u);
    }



    public function archiveItem ($itemId) {
        $c_pages = new controller_pages();
        $result = $this->model->archiveItem($itemId);

        if ($result) {
            $m = 'Item has been archived successfully';
        } else {
            $m = '<span style="color: #f00;">Error</span>: Item failed to be archived.';
        }

        $u = URL_BASE.'inventory/read_item/'.$itemId.'/';
        $c_pages->pageRedirect($m, $u);
    }



    public function countComponents ($itemId) {
        $result = $this->model->readItemComponents($itemId);
        return count($result);
    }

}
