<?php

class controller_items {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_items();
        $this->view = new view_items();
    }



    public function displayForm ($itemId=null) {
        if ($itemId != null) {
            $detailsItem = $this->model->readItem($itemId);
            $detailsCurrentOwner = $this->model->readItemOwner($itemId);

            $infos = array(
                'item'=>$detailsItem
                ,'owner'=>$detailsCurrentOwner);
        } else {
            $infos = array(
                'item'=>null
                ,'owner'=>null);
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



    public function displayItemName ($itemId=null, $echo=true) {
        $item = $this->model->readItem($itemId);
        $itemName = $this->view->renderItemName($item);
        if (!$echo) return $itemName;
        echo $itemName;
    }



    public function displayItemCurrentOwner ($itemId, $echo=true) {
        $currentOwner = $this->model->readItemOwner($itemId);
        $output = $this->view->renderItemCurrentOwner($currentOwner);
        if (!$echo) return $output;
        echo $output;
    }



    public function displaySearchResults ($searchType='item', $keyword) {
        if (strlen(trim($keyword)) < 1) {
            echo 'Keywords can match the ff:<br />'
                ,'Item Name<br />'
                ,'Item Serial No<br />'
                ,'Item Model No';
            return;
        }

        $results = $this->model->searchItems($searchType, $keyword);
        echo $this->view->renderSearchResults($results);
    }



    public function saveItem () {
        if (isset($_POST)) {
            $datas = $this->model->createItem($_POST);
            $d = $datas;
            if ($d != null) {
                $currentOwner = $this->model->readItemOwner($d['item-id']);
                $co = $currentOwner;

                if ($co != null) {
                    if ($co['ownership_owner'] != $d['ownership-owner']) {
                        $this->model->deleteItemOwnership($co['ownership_id']);
                        if ($d['ownership-owner'] != '0')
                            $this->model->createItemOwnership($d);
                    }
                } else {
                    if ($d['ownership-owner'] != 0)
                        $this->model->createItemOwnership($d);
                }

                header('location: '.URL_BASE.'inventory/read_item/'.$d['item-id'].'/');
            } else header('location: '.URL_BASE.'inventory/new_item/');
        } else header('location: '.URL_BASE.'inventory/new_item/');
    }



    public function updateItem () {
        if (isset($_POST)) {
            $datas = $this->model->updateItem($_POST);
            $d = $datas;
            if ($d != null) {
                $currentOwner = $this->model->readItemOwner($d['item-id']);
                $co = $currentOwner;

                if ($co != null) {
                    if ($co['ownership_owner'] != $d['ownership-owner']) {
                        $this->model->deleteItemOwnership($co['ownership_id']);
                        if ($d['ownership-owner'] != '0')
                            $this->model->createItemOwnership($d);
                    } else {
                        $d['ownership-id'] = $co['ownership_id'];
                        $this->model->updateItemOwnership($d);
                    }
                } else {
                    if ($d['ownership-owner'] != '0')
                        $this->model->createItemOwnership($d);
                }
            }
            header('location: '.URL_BASE.'inventory/read_item/'.$d['item-id'].'/');
        } else header('location: '.URL_BASE.'inventory/');
    }



    public function deleteItem ($itemId) {
        $result = $this->model->deleteItem($itemId);
        if (!$result) header('location: '.URL_BASE.'inventory/read_item/'.$itemId.'/');
        else header('location: '.URL_BASE.'inventory/');
    }

}
