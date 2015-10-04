<?php

namespace Framework\Repositories;


class Repositories
{
    /**
     * @var \Framework\Repositories\UserRepository;
     */
    private static $userRepo;

    /**
     * @var \Framework\Repositories\ProductRepository;
     */
    private static $productRepo;

    /*
     * @var \Framework\Repositories\CategoryRepository;
     */
    private static $categoryRepo;

    public function __construct() {
        self::$userRepo = UserRepository::create();
        self::$productRepo = ProductRepository::create();
        self::$categoryRepo = CategoryRepository::create();
    }

    /**
     * @return UserRepository
     */
    public static function getUserRepo()
    {
        return self::$userRepo;
    }

    /**
     * @return ProductRepository
     */
    public static function getProductRepo()
    {
        return self::$productRepo;
    }

    /**
     * @return CategoryRepository
     */
    public static function getCategoryRepo()
    {
        return self::$categoryRepo;
    }
}