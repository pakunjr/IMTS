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



    public function displayItem ($itemId=null) {
        if ($itemId != null) {
            $detailsItem = $this->model->readItem($itemId);
            $detailsOwners = $this->model->readItemOwners($itemId);
            $detailsComponents = $this->model->readItemComponents($itemId);

            if ($detailsComponents != null) {
                foreach ($detailsComponents as $dc => $array) {
                    $currentOwner = $this->model->readItemOwner($array['item_id']);
                    $detailsComponents[$dc]['ownership'] = $currentOwner;
                }
            }

            $infos = array(
                'item'=>$detailsItem
                ,'owners'=>$detailsOwners
                ,'components'=>$detailsComponents);
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



    public function saveItem () {
        $c_errors = new controller_errors();

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
                header('location: '.URL_BASE.'inventory/read_item/'.$d['item-id'].'/');
            } else {
                $c_errors->logError('System failed to save the new item.');
                exit('<span style="display: inline-block; color: #f00;">SYSTEM ERROR: Failed to save the new item.'
                    .'<br />Exiting...<br /><br />'
                    .'<a href="'.URL_BASE.'inventory/create_item/"><input type="button" value="Back to New Item Form." /></a></span>');
            }
        } else {
            $c_errors->logError('Save new item is being accessed directly without using the form, thus not passing any data.');
            exit('<span style="display: inline-block; color: #f00;">USER ERROR: The system do not know how you got here but you are on the wrong page.'
                .'<br />Exiting...<br /><br />'
                .'<a href="'.URL_BASE.'inventory/create_item/"><input type="button" value="Back to New Item Form." /></a></span>');
        }
    }



    public function updateItem () {
        $c_errors = new controller_errors();

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
            } else
                $c_errors->logError('System failed to update the item.');
                
            header('location: '.URL_BASE.'inventory/read_item/'.$d['item-id'].'/');
        } else {
            $c_errors->logError('Update item is being accessed directly without using the form, thus not passing any data.');
            exit('<span style="display: inline-block; color: #f00;">USER ERROR: The system do not know how you got here but you are on the wrong page.'
                .'<br />Exiting...<br /><br />'
                .'<a href="'.URL_BASE.'inventory/create_item/"><input type="button" value="Back to New Item Form." /></a></span>');
        }
    }



    public function archiveItem ($itemId) {
        $result = $this->model->archiveItem($itemId);
        header('location: '.URL_BASE.'inventory/read_item/'.$itemId.'/');
    }

}
