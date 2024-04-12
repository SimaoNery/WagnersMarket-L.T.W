<?php
    declare(strict_types=1);

    class Category {
        public string $categoryName;

        public function __construct(string $categoryName)
        {
            $this->categoryName = $categoryName;
        }

        static function getCategories(PDO $db) : array {
            $stmt = $db->prepare('SELECT CategoryName FROM CATEGORY');
            $stmt->execute(array());

            $categories = array();
            while ($category = $stmt->fetch()) {
                $categories[] = new Category($category['CategoryName']);
            }

            return $categories;
        }
    }
?>
