<?php
declare(strict_types=1);

class ItemCategory
{
    public string $categoryId;
    public int $itemId;

    public function __construct(string $categoryId, int $itemId)
    {
        $this->categoryId = $categoryId;
        $this->itemId = $itemId;
    }

    static function getItemsByCategory(PDO $db, string $categoryName): array {
        $items = array();
        $stmt = $db->prepare('SELECT * FROM ITEM_CATEGORY WHERE CategoryId = ?');
        $stmt->execute(array($categoryName));

        while ($item = $stmt->fetch()) {
            $items[] = new ItemCategory(
                $item['CategoryId'],
                $item['ItemId'],
            );
        }

        return $items;
    }
}

?>
