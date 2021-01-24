<?php


namespace Model\routes;

use Model\routes\Route;

class Router
{
    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $call, $name = null)
    {
        return $this->add($path, $call, $name, 'GET');
    }

    public function post($path, $call, $name = null)
    {
        return $this->add($path, $call, $name, 'POST');
    }

    private function add($path, $call, $name, $method)
    {
        $route = new Route($path, $call);
        $this->routes[$method][] = $route;
        if (is_string($call) && $name === null) {
            $name = $call;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function start()
    {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
        throw new RouterException('No routes matches');
    }
}
