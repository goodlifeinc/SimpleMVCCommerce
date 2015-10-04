<?php
/**
 * Created by PhpStorm.
 * User: Evgeni
 * Date: 30.09.2015 �.
 * Time: 09:44 �.
 */

namespace Framework\Models;


use Framework\Config\ApplicationConfig;
use Framework\Core\Database;
use Framework\Repositories\UserRepository;

class User extends BaseModel
{
    /**
     * @var \Framework\Repositories\UserRepository;
     */
    private static $repo;

    const INITIAL_CASH = 5;
    const ADMIN_ROLE = 1;
    const EDITOR_ROLER = 2;
    const USER_ROLE = 3;

    private $username;
    private $password;
    private $id;

    public function __construct($username = null, $password = null, $id=null, $repo = null) {
        if($username != null) {
            $this->setUsername($username);
        }
        if($password != null) {
            $this->setPassword($password);
        }
        if($id != null) {
            $this->setId($id);
        }
        if (self::$repo == null) {
            self::$repo = $repo;
        }
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return htmlspecialchars_decode($this->username);
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = htmlspecialchars($username);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function exists($username) {
        return self::$repo->exists($username);
    }

    public function register($username, $password, $firstname = null, $lastname = null, $email = null, $role, $cash) {
        return self::$repo->register($username, $password, $firstname, $lastname, $email, $role, $cash);
    }

    public function login($username, $password) {
        return self::$repo->login($username, $password);
    }

    public function getInfo($id) {
        return self::$repo->getInfo($id);
    }

    public function edit(User $user) {
        return self::$repo->edit($user);
    }
}