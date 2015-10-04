<?php
/**
 * Created by PhpStorm.
 * User: Evgeni
 * Date: 1.10.2015 ã.
 * Time: 22:23 ÷.
 */

namespace Framework\Models;


class Category
{
    private $id = null;
    private $name;
    private $description = null;
    private $parent_id = null;

    public function __construct($id = null, $name, $description = null, $parent_id = null) {
        $this->setId($id);
        $this->setName($name);
        if($description) {
            $this->setDescription($description);
        }
        if($parent_id) {
            $this->setParentId($parent_id);
        }
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
     * @return null
     */
    public function getDescription()
    {
        return htmlspecialchars_decode($this->description);
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = htmlspecialchars($description);
    }

    /**
     * @return null
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param null $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }
}