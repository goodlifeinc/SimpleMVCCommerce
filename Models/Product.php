<?php
/**
 * Created by PhpStorm.
 * User: Evgeni
 * Date: 1.10.2015 ã.
 * Time: 21:22 ÷.
 */

namespace Framework\Models;


use Framework\Repositories\UserRepository;

class Product
{
    private $id;
    private $name;
    private $description = null;
    private $code = null;
    private $price;
    private $user_owner_id;
    private $image_url = null;
    private $available;

    public function __construct($id = null, $name, $description = null, $code = null, $price, $user_owner_id, $image_url = null, $available) {
        if($id) {
            $this->setId($id);
        }
        $this->setName($name);
        if($description) {
            $this->setDescription($description);
        }
        if($code) {
            $this->setCode($code);
        }
        $this->setPrice($price);
        $this->setUserOwnerId($user_owner_id);
        $this->setImageUrl($image_url);
        $this->setAvailable($available);
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
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return htmlspecialchars_decode($this->name);
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = htmlspecialchars($name);
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return htmlspecialchars_decode($this->description);
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = htmlspecialchars($description);
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return htmlspecialchars_decode($this->code);
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = htmlspecialchars($code);
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return htmlspecialchars_decode($this->price);
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = htmlspecialchars($price);
    }

    /**
     * @return mixed
     */
    public function getUserOwnerId()
    {
        return $this->user_owner_id;
    }

    /**
     * @param mixed $user_owner_id
     */
    public function setUserOwnerId($user_owner_id)
    {
        $this->user_owner_id = $user_owner_id;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * @param mixed $image_url
     */
    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
    }

    /**
     * @return mixed
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param mixed $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }
}