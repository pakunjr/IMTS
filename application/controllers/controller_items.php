<?php

class controller_items {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_items();
        $this->view = new view_items();
    }



    public function displayForm ($itemId=null, $niboti=null) {
        if ($itemId != null) {
            $infos = array(
                'item'=>$this->model->readItem($itemId)
                ,'owner'=>$this->model->readItemOwner($itemId)
                ,'niboti'=>false);
        } else {
            $infos = array(
                'item'=>$niboti != null
                    ? $this->model->readItem($niboti)
                    : null
                ,'owner'=>$niboti != null
                    ? $this->model->readItemOwner($niboti)
                    : null
                ,'niboti'=>$niboti != null ? true : false);
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
        if (!$echo) return $output;
        echo $output;
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



    public function archiveItem ($itemId) {
        $result = $this->model->archiveItem($itemId);
        header('location: '.URL_BASE.'inventory/read_item/'.$itemId.'/');
    }

}
