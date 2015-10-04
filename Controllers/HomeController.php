<?php

namespace Framework\Controllers;


use Framework\Repositories\UserRepository;
use Framework\ViewModels\BaseViewModel;

class HomeController extends BaseController
{
    private $viewModel;
    private $categoryRepo;

    public function onInit() {
        $this->categoryRepo = $this->repositories->getCategoryRepo();
        $this->viewModel = new BaseViewModel();
        $this->viewModel->baseUrl = $this->baseUrl;
        $this->viewModel->categories = $this->categoryRepo->getAll();
        $this->title = 'Home | SimpleMVC PHP Framework';
        $action = $this->action;
        self::$action();
    }

    public function index() {
        $this->viewModel->title =  'Hello SimpleMVC PHP Framework';
        $this->renderView($this->viewModel);
    }

    public function notFound() {
        $server = explode("/", $_SERVER['REQUEST_URI']);
        if($server[count($server) - 1] != 'notfound') {
            $this->redirect('home', 'notfound');
        }
        $this->viewModel->error = 'Page not found';
        $this->renderView($this->viewModel);
    }
}