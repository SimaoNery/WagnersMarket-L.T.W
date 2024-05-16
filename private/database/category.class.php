<?php
declare(strict_types=1);
class Category
{
    public string $categoryName;
    public string $categoryImage;

    public function __construct(string $categoryName, string $categoryImage)
    {
        $this->categoryName = $categoryName;
        $this->categoryImage = $categoryImage;
    }

    static function getCategories(PDO $db): array
    {
        $stmt = $db->prepare('SELECT CategoryName, CategoryImage FROM CATEGORY');
        $stmt->execute(array());

        $categories = array();
        while ($category = $stmt->fetch()) {
            $categories[] = new Category(
                $category['CategoryName'],
                $category['CategoryImage']
            );
        }

        return $categories;
    }

    static function addCategory(PDO $db, string $categoryName, string $categoryImage): bool
    {
        $stmt = $db->prepare('INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES (?, ?)');
        $stmt->execute(array($categoryName, $categoryImage));
        return $stmt->rowCount() == 1;
    }

    static function deleteCategory(PDO $db, string $categoryName): bool
    {
        $stmt = $db->prepare('DELETE FROM CATEGORY WHERE CategoryName = ?');
        return $stmt->execute(array($categoryName));
    }

    static function updateCategoryImage(PDO $db, string $categoryName, string $categoryImage): bool
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM CATEGORY WHERE CategoryName = ?');
        $stmt->execute(array($categoryName));
        $count = $stmt->fetchColumn();
        if ($count !== 0) {
            $stmt = $db->prepare('UPDATE CATEGORY SET CategoryImage = ? WHERE CategoryName = ?');
            return $stmt->execute(array($categoryImage, $categoryName));
        }
        return false;
    }
}

?>
