<?php

namespace Model;

class View {
    private $params;

    function __construct(){
        $this->params = array();
    }

    function assign(string $var, $val){
        $this->params[$var] = $val;
    }

    function display(string $view){
        $path = __DIR__ . "/../views/" .$view;

        foreach($this->params as $key => $value){
            $$key = $value;
        }
        require($path);
        exit(0);
    }
}
