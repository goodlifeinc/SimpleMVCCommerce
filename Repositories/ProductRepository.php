<?php

namespace Framework\Repositories;


use Framework\Config\ApplicationConfig;
use Framework\Core\Database;
use Framework\Models\Product;

class ProductRepository extends BaseRepository
{
    /**
     * @var \Framework\Core\Database
     */
    private $db;

    /**
     * @var ProductRepository
     */
    private static $inst;

    public function __construct(\Framework\Core\Database $db) {
        $this->db = $db;
    }

    /**
     * @return ProductRepository
     * @throws \Exception
     */
    public static function create() {
        if(self::$inst == null) {
            self::$inst = new self(Database::getIntance(ApplicationConfig::DB_INSTANCE));
        }

        return self::$inst;
    }


    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    public function getOne($id)
    {
        $query = '
            SELECT id, name, description, code, price, user_owner_id, image_url, available, created_at
            FROM products
            WHERE id = ?
        ';

        $result = $this->db->prepare($query);
        $result->execute([$id]);

        if ($result->rowCount() == 0) {
            throw new \Exception('Invalid product id');
        }

        $productRow = $result->fetch();

        return new Product(
            $productRow['id'],
            $productRow['name'],
            $productRow['description'],
            $productRow['code'],
            $productRow['price'],
            $productRow['user_owner_id'],
            $productRow['image_url'],
            $productRow['available'],
            $productRow['created_at']
        );
    }

    public function getAll()
    {
        $query = '
            SELECT id, name, description, code, price, user_owner_id, image_url, available, created_at
            FROM products
        ';

        $result = $this->db->prepare($query);
        $result->execute();

        if ($result->rowCount() == 0) {
            throw new \Exception('No products found');
        }

        $products = $result->fetchAll();

        $products = array_map(function($productRow) {
            return new Product(
                $productRow['id'],
                $productRow['name'],
                $productRow['description'],
                $productRow['code'],
                $productRow['price'],
                $productRow['user_owner_id'],
                $productRow['image_url'],
                $productRow['available'],
                $productRow['created_at']
            );
        }, $products);

        return $products;
    }

    public function save($product)
    {
        $query = "
            INSERT INTO products (name, description, code, price, user_owner_id, image_url, available)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";
        $params = [
            htmlspecialchars($product->getName()),
            htmlspecialchars($product->getDescription()),
            htmlspecialchars($product->getCode()),
            htmlspecialchars($product->getPrice()),
            $product->getUserOwnerId(),
            $product->getImageUrl(),
            $product->getAvailable()
        ];

        $result = $this->db->prepare($query);
        $result->execute($params);

        return $result->rowCount() > 0;
    }

    public function getAllFromCategory($category_id) {
        $query = '
            SELECT id, name, description, code, price, user_owner_id, image_url, available, created_at
            FROM products
            WHERE id IN (SELECT product_id FROM products_categories WHERE category_id = ?)
        ';

        $result = $this->db->prepare($query);
        $result->execute([$category_id]);

        if ($result->rowCount() == 0) {
            throw new \Exception('No products found');
        }

        $products = $result->fetchAll();

        $products = array_map(function($productRow) {
            return new Product(
                $productRow['id'],
                $productRow['name'],
                $productRow['description'],
                $productRow['code'],
                $productRow['price'],
                $productRow['user_owner_id'],
                $productRow['image_url'],
                $productRow['available'],
                $productRow['created_at']
            );
        }, $products);
        return $products;
    }

    public function addProductToCategory($product_id, $category_id) {
        $query = '
            INSERT INTO products_categories (product_id, category_id) VALUES (?, ?)
        ';

        $result = $this->db->prepare($query);
        $result->execute(
            [
                $product_id,
                $category_id
            ]);

        if ($result->rowCount() == 0) {
            throw new \Exception('Product not added to category!');
        }
    }

    public function getLastId() {
        return $this->db->lastId();
    }
}