<?php

class model_pages {

    private $model;
    private $view;
    private $controller;
    private $action;
    private $extra;

    public function get ($data) {
        return $this->$data;
    }



    public function set ($data, $value) {
        $this->$data = $value;
    }



    public function routeUrl ($url) {
        $d_url = explode('/', $url);

        $model = isset($d_url[0]) ? $d_url[0] : 'Home';
        $view = isset($d_url[1]) ? $d_url[1] : null;
        $controller = isset($d_url[2]) ? $d_url[2] : null;
        $action = isset($d_url[3]) ? $d_url[3] : null;

        $extra = '';
        if (count($d_url) > 4) {
            foreach ($d_url as $index => $value) {
                if ($index > 3) $extra .= $value.'/';
            }
        }

        $this->model = $model;
        $this->view = $view;
        $this->controller = $controller;
        $this->action = $action;
        $this->extra = $extra;
    }

}
