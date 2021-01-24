<?php


namespace Controller;

use Model\View;

class errorController {

    private View $view;

    public function __construct() {
        $this->view = new View();
    }

    public function display($message){
        $this->view->assign("message", $message);
        $this->view->display("error.view.php");
    }
}