<?php

class controller_itemTypes {

    private $model;
    private $view;

    public function __construct ($model=null) {
        $this->model = $model != null ? $model : new model_itemTypes();
        $this->view = new view_itemTypes();
    }



    public function __destruct () {

    }



    public function displaySelectForm ($options=array(), $echo=true) {
        $types = $this->model->readItemTypes();
        $form = $this->view->renderSelectForm($types, $options);
        if (!$echo)
            return $form;
        echo $form;
    }



    public function displayItemTypeName ($typeId, $echo=true) {
        $itemType = $this->model->readItemType($typeId);
        $name = $this->view->renderItemTypeName($itemType);
        if (!$echo)
            return $name;
        echo $name;
    }

}
