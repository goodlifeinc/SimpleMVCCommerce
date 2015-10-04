<?php
/**
 * Created by PhpStorm.
 * User: Evgeni
 * Date: 1.10.2015 ã.
 * Time: 22:29 ÷.
 */

namespace Framework\Controllers;


use Framework\Helpers\Csfr;
use Framework\Models\Category;
use Framework\ViewModels\CategoryViewModel;

class CategoryController extends BaseController
{
    /*
     * @var CategoryViewModel
     */
    private $viewModel;
    private $categoryRepo;
    private $productRepo;

    protected function onInit() {
        Csfr::generate();

        $action = $this->action;
        $this->categoryRepo = $this->repositories->getCategoryRepo();
        $this->productRepo = $this->repositories->getProductRepo();

        $this->viewModel = new CategoryViewModel();
        $this->viewModel->baseUrl = $this->baseUrl;
        $this->viewModel->categories = $this->categoryRepo->getAll();
        if($this->params != null) {
            self::$action($this->params);
        } else {
            self::$action();
        }
    }

    public function show($params) {
        $id = $params[0];

        try {
            $this->viewModel->category = $this->categoryRepo->getOne($id);
            try {
                $this->viewModel->products = $this->productRepo->getAllFromCategory($id);
            }
            catch (\Exception $e) {
                $this->viewModel->products = false;
            }
            $this->renderView($this->viewModel, 'category/index');

        }
        catch (\Exception $e) {
            $this->redirect('home', 'notfound');
        }
    }

    public function add() {
        if(!$this->isLoggedIn() || $this->isUser()) {
            $this->redirect('home', 'index');
        }

        $this->viewModel->user = $this->repositories->getUserRepo()->getInfo($this->getLoggedUserId());

        if(isset($_POST) && !empty($_POST)) {
            $category = new Category(
                null,
                $_POST['name'],
                $_POST['description']
            );
            $addCategory = $this->categoryRepo->save($category);
            if($addCategory) {
                $this->viewModel->success = 'Category successfully added';
            }
            else {
                $this->viewModel->error = 'Some error..';
            }
        }

        $this->renderView($this->viewModel);
    }
}