<?php


namespace Model\routes;


class Route {
    private $path;
    private $call;
    private $matches = [];
    private $params = [];

    public function __construct($path, $call){
        $this->path = trim($path, '/');
        $this->call = $call;
    }

    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '('.$this->params[$match[1]].')';
        }
        return '([^/]+)';
    }

    public function with($param, $regex){
        $this->params[$param] = str_replace('(','(?:',$regex);
        return $this;
    }

    public function call() {
        if(is_string($this->call)){
            $params = explode('.', $this->call);
            $controller = "Controller\\".$params[0]."Controller";
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        }else {
            return call_user_func_array($this->call, $this->matches);
        }
    }
}