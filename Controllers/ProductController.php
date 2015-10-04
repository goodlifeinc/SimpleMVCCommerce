<?php

namespace Framework\Controllers;

use Framework\Models\Product;
use Framework\ViewModels\ProductViewModel;

class ProductController extends BaseController
{
    private $viewModel;
    private $categoryRepo;
    private $productRepo;

    protected function onInit() {
        $action = $this->action;
        $this->categoryRepo = $this->repositories->getCategoryRepo();
        $this->productRepo = $this->repositories->getProductRepo();
        $this->viewModel = new ProductViewModel();
        $this->viewModel->baseUrl = $this->baseUrl;
        $this->viewModel->categories = $this->categoryRepo->getAll();
        if($this->params != null) {
            self::$action($this->params);
        } else {
            self::$action();
        }
    }

    public function index() {
        $viewModel = new ProductViewModel();
        $this->renderView($viewModel, 'home/index');
    }

    public function show($params) {
        $id = $params[0];
        try {
            $this->viewModel->product = $this->productRepo->getOne($id);
            $this->renderView($this->viewModel, 'product/listing');

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
            $image_url = $this->handleUpload();
            $product = new Product(
                null,
                $_POST['name'],
                $_POST['description'],
                $_POST['code'],
                $_POST['price'],
                $this->getLoggedUserId(),
                $image_url,
                1
            );
            $addProduct = $this->productRepo->save($product);
            if($addProduct) {
                $lastId = $this->productRepo->getLastId();
                foreach($_POST['categories'] as $catId) {
                    $this->productRepo->addProductToCategory($lastId, $catId);
                }
                $this->viewModel->success = 'Product successfully added';
            }
            else {
                $this->viewModel->error = 'Some error..';
            }
        }

        $this->renderView($this->viewModel);
    }

    private function handleUpload() {
        $target_dir = "public/uploads/";
        $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image_url"]["tmp_name"]);
            if($check !== false) {
                $this->viewModel->error = "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
// Check if file already exists
        if (file_exists($target_file)) {
            $this->viewModel->error = "Sorry, file already exists.";
            $uploadOk = 0;
        }
// Check file size
        if ($_FILES["image_url"]["size"] > 500000) {
            $this->viewModel->error = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            $this->viewModel->error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $this->viewModel->error = "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
                $this->viewModel->success = "The file ". basename( $_FILES["image_url"]["name"]). " has been uploaded.";
                return basename($_FILES["image_url"]["name"]);
            } else {
                $this->viewModel->error = "Sorry, there was an error uploading your file.";
            }
        }
    }
}