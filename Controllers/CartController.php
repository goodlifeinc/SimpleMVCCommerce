<?php

namespace Framework\Controllers;


use Framework\ViewModels\BaseViewModel;

class CartController extends BaseController
{
    private $viewModel;
    private $productRepo;
    private $categoryRepo;

    protected function onInit() {
        $action = $this->action;

        $this->categoryRepo = $this->repositories->getCategoryRepo();
        $this->productRepo = $this->repositories->getProductRepo();

        $this->viewModel = new BaseViewModel();
        $this->viewModel->baseUrl = $this->baseUrl;
        $this->viewModel->categories = $this->categoryRepo->getAll();
        if($this->params != null) {
            self::$action($this->params);
        } else {
            self::$action();
        }
    }

    public function update()
    {
        $productRepo = $this->repositories->getProductRepo();

        //add product to session or create new one
        if (isset($_POST["type"]) && $_POST["type"] == 'add' && $_POST["product_qty"] > 0) {
            foreach ($_POST as $key => $value) { //add all post vars to new_product array
                $new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
            }
            //remove unecessary vars
            unset($new_product['type']);
            unset($new_product['return_url']);

                try {
                    $product = $productRepo->getOne($new_product['product_code']);

                    //fetch product name, price from db and add to new_product array
                    $new_product["product_name"] = $product->getName();
                    $new_product["product_price"] = $product->getPrice();

                    if (isset($_SESSION["cart_products"])) {  //if session var already exist
                        if (isset($_SESSION["cart_products"][$new_product['product_code']])) //check item exist in products array
                        {
                            unset($_SESSION["cart_products"][$new_product['product_code']]); //unset old array item
                        }
                    }
                    $_SESSION["cart_products"][$new_product['product_code']] = $new_product; //update or create product session with new item
                }
                catch (\Exception $e) {
                    echo $e->getMessage();
                }

        }


        //update or remove items
        if (isset($_POST["product_qty"]) || isset($_POST["remove_code"])) {
            //update item quantity in product session
            if (isset($_POST["product_qty"]) && is_array($_POST["product_qty"])) {
                foreach ($_POST["product_qty"] as $key => $value) {
                    if (is_numeric($value)) {
                        $_SESSION["cart_products"][$key]["product_qty"] = $value;
                    }
                }
            }
            //remove an item from product session
            if (isset($_POST["remove_code"]) && is_array($_POST["remove_code"])) {
                foreach ($_POST["remove_code"] as $key) {
                    unset($_SESSION["cart_products"][$key]);
                }
            }
        }
        // TO-DO REDIRECT TO PREVIOUS URL
        $this->redirect();
    }

    public function view() {
        if(empty($_SESSION['cart_products'])) {
            $this->viewModel->error = 'Your cart is empty. There is nothing you can checkout!';
        }
        $this->renderView($this->viewModel, null, true, false);
    }

    public function checkout() {
        if(empty($_SESSION['cart_products'])) {
            $this->viewModel->error = 'Your cart is empty. There is nothing you can checkout!';
        }
        else {
            $cart = [];
            $cart['totalAmount'] = $_POST['total_amount'];
            $this->viewModel->cart = $cart;
        }

        $this->renderView($this->viewModel, null, true, false);
    }

    public function checkout_success() {
        var_dump($_POST);
        // TODO create order table, order model, ordersrepository, with add method;
        //$this->orderRepo->add($order);
        $_SESSION['cart_products'] = [];
        echo 'Cart_products from session are cleared now, your ordered must be in place..';
    }
}