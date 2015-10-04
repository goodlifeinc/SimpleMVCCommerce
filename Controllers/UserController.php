<?php

namespace Framework\Controllers;


use Framework\Models\User;
use Framework\ViewModels\BaseViewModel;
use Framework\ViewModels\User\ErrorHandlerViewModel;

class UserController extends BaseController
{
    private $viewModel;

    protected function onInit() {
        $action = $this->action;
        $this->viewModel = new BaseViewModel();
        $this->viewModel->baseUrl = $this->baseUrl;
        $this->viewModel->categories = $this->repositories->getCategoryRepo()->getAll();
        self::$action();
    }

    public function index() {
        $this->viewModel->title = 'User index';
        $this->renderView($this->viewModel, 'home/index');
    }

    private function initLogin($username, $passowrd) {
        $userModel = new User(null, null, null, $this->repositories->getUserRepo());

        $userId = $userModel->login($username, $passowrd);
        $userModel = $userModel->getInfo($userId);
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $userModel['username'];
        $_SESSION['firstname'] = $userModel['firstname'];
        $_SESSION['lastname'] = $userModel['lastname'];
        $_SESSION['role_id'] = $userModel['role_id'];

        $this->redirect();
    }

    public function register() {
        if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {
            try {
                $user = $_POST['username'];
                $pass = $_POST['password'];
                $email = $_POST['email'];


                $userModel = new User(null, null, null, $this->repositories->getUserRepo());
                $userModel->register($user, $pass, null, null, $email, $userModel::USER_ROLE, $userModel::INITIAL_CASH);

                $this->initLogin($user, $pass);

            } catch (\Exception $e) {
                $this->viewModel->error = $e->getMessage();
                $this->renderView($this->viewModel);
            }
        }

        $this->renderView($this->viewModel);
    }

    public function login() {
        if (isset($_POST['username'], $_POST['password'])) {
            try {
                $user = $_POST['username'];
                $pass = $_POST['password'];

                $this->initLogin($user, $pass);

            } catch (\Exception $e) {
                $this->viewModel->error = $e->getMessage();
                $this->renderView($this->viewModel);
            }
        }

        $this->renderView($this->viewModel);
    }

    public function profile() {
        if($this->getLoggedUserId()) {
            $userModel = new User(null, null, null, $this->repositories->getUserRepo());
            $user = $userModel->getInfo($this->getLoggedUserId());
            $this->viewModel->user = new User($user['username'], $user['password'], $user['id']);

            if(isset($_POST['edit'])) {
                $username = $_POST['username'];
                $pass = $_POST['password'];
                $confirm = $_POST['confirm'];
                if($pass != $confirm) {
                    $viewModel->error = 'Password does not match';
                    $this->renderView($viewModel);
                }
                else {
                    $newUser = new User($username, $pass, $this->getLoggedUserId());
                    $result = $this->repositories->getUserRepo()->edit($newUser);
                    if ($result) {
                        $viewModel->user = $newUser;
                        $viewModel->success = 'Profile successfully edited';
                        $this->renderView($viewModel);
                    }
                }
            }

            $this->renderView($this->viewModel);
        }

        $this->renderView($this->viewModel);
    }

    public function logout() {
        session_destroy();
        $this->redirect();
    }
}