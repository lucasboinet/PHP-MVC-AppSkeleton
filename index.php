<?php
//error_reporting(0);
require_once './vendor/autoload.php';

$router = new Model\routes\Router($_GET['url']);

$router->get('/', "default.display");

try {
    $router->start();
} catch (\Model\routes\RouterException $e) {
    $error = new \Controller\errorController();
    $error->display($e);
}
