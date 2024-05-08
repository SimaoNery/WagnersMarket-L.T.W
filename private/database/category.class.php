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
}

?>
