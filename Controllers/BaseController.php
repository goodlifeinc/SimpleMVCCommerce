<?php
namespace Framework\Controllers;

use Framework\Repositories\Repositories;

abstract class BaseController
{
    protected $controller;
    protected $action;
    protected $params;
    protected $repo;
    protected $baseUrl;

    public function __construct($controller, $action, $params = null) {
        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
        $this->repositories = new Repositories();
        $this->baseUrl = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        if(!method_exists($this, $action)) {
            $this->redirect('home', 'notfound');
        }
        else {
            $this->onInit();
        }
    }

    protected function onInit() {}

    public function renderView($model, $viewName = null, $leftColumn = true, $rightColumn = true) {

        $header = 'Views/header_guest.php';
        if($this->isLoggedIn()) {
            $header = 'Views/header.php';
        }

        require_once $header;

        echo '<div class="content clearfix">';

        if($leftColumn) {
            require_once 'Views/left_column.php';
        }

        $view = $viewName ? $viewName : $this->controller
            . '/' . $this->action;

        echo '<div class="main">';
        require_once '/Views/' . $view . '.php';
        echo '</div>';

        if($rightColumn) {
            require_once 'Views/right_column.php';
        }

        echo '</div>';

        require_once '/Views/footer.php';
    }

    protected function redirect(
        $controller = null, $action = null, $params = [])
    {
        $uri = $controller ? $controller . '/' : '';
        $uri .= $action ? $action : '';
        if (!empty($params)) {
            $uri .= '/';
            foreach($params as $param) {
                $uri .= $param . '/';
            }
        }
        header('Location: ' . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) . $uri);
        die;
    }

    public function getLoggedUserId() {
        if($this->isLoggedIn()) {
            return $_SESSION['user_id'];
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getUserRole() {
        if($this->isLoggedIn()){
            return $_SESSION['role_id'];
        }
    }

    public function isAdmin() {
        if($this->isLoggedIn()){
            return $_SESSION['role_id'] == 1;
        }
    }

    public function isEditor() {
        if($this->isLoggedIn()){
            return $_SESSION['role_id'] == 2;
        }
    }

    public function isUser() {
        if($this->isLoggedIn()){
            return $_SESSION['role_id'] == 3;
        }
    }
}