<?php


namespace Controller;

use Model\View;

class defaultController
{

    private View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function display()
    {
        $this->view->display("index.view.php");
    }
}
