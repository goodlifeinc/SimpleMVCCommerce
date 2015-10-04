<?php

namespace Framework\Repositories;


use Framework\Config\ApplicationConfig;
use Framework\Core\Database;
use Framework\Models\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * @var \Framework\Core\Database
     */
    private $db;

    /**
     * @var CategoryRepository
     */
    private static $inst;

    public function __construct(\Framework\Core\Database $db) {
        $this->db = $db;
    }

    /**
     * @return CategoryRepository
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
            SELECT id, name, description, parent_id
            FROM categories
            WHERE id = ?
        ';

        $result = $this->db->prepare($query);
        $result->execute([$id]);

        if ($result->rowCount() == 0) {
            throw new \Exception('Invalid userid');
        }

        $categoryRow = $result->fetch();

        return new Category(
            $categoryRow['id'],
            $categoryRow['name'],
            $categoryRow['description'],
            $categoryRow['parent_id']
        );
    }

    public function getAll()
    {
        $query = '
            SELECT id, name, description, parent_id
            FROM categories
        ';

        $result = $this->db->prepare($query);
        $result->execute();

        if ($result->rowCount() == 0) {
            throw new \Exception('No users found');
        }

        $categories = $result->fetchAll();

        $categories = array_map(function($categoryRow) {
            return new Category(
                $categoryRow['id'],
                $categoryRow['name'],
                $categoryRow['description'],
                $categoryRow['parent_id']
            );
        }, $categories);

        return $categories;
    }

    public function save($category)
    {
        $query = "
            INSERT INTO categories (name, description, parent_id)
            VALUES (?, ?, ?)
        ";
        $params = [
            htmlspecialchars($category->getName()),
            htmlspecialchars($category->getDescription()),
            $category->getParentId()
        ];

        $result = $this->db->prepare($query);
        $result->execute($params);

        return $result->rowCount() > 0;
    }

}