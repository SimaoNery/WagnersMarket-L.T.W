<?php
declare(strict_types=1);

class Item
{
    public int $itemId;
    public int $userId;
    public string $title;
    public float $price;
    public string $description;
    public string $condition;
    public string $size;
    public string $brand;
    public string $imagePath;
    public int $wishlistCounter;


    public function __construct(int $itemId, int $userId, string $title, float $price, string $description, string $condition, string $size, string $brand, string $imagePath, int $wishlistCounter)
    {
        $this->itemId = $itemId;
        $this->userId = $userId;
        $this->title = $title;
        $this->price = $price;
        $this->description = $description;
        $this->condition = $condition;
        $this->size = $size;
        $this->brand = $brand;
        $this->imagePath = $imagePath;
        $this->wishlistCounter = $wishlistCounter;

    }

    static function getNumItems(PDO $db): int
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM ITEM');
        $stmt->execute();
        return (int)$stmt->fetch(PDO::FETCH_COLUMN, 0);
    }

    static function getNumItemsWishlist(PDO $db, int $userId): int
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM ITEM JOIN WISHLIST ON ITEM.ItemId = WISHLIST.ItemId WHERE WISHLIST.UserId = ? ');
        $stmt->execute(array($userId));
        return (int)$stmt->fetch(PDO::FETCH_COLUMN, 0);
    }


    static function getItems(PDO $db, int $count, int $offset): array
    {
        $stmt = $db->prepare('SELECT ItemId, UserId, Title, Price, Description, Condition, 
            Size, Brand, ImagePath, WishlistCounter FROM ITEM ORDER BY WishlistCounter DESC LIMIT ? OFFSET ?');
        $stmt->execute(array($count, $offset));

        $items = array();
        while ($item = $stmt->fetch()) {
            $items[] = new Item(
                $item['ItemId'],
                $item['UserId'],
                $item['Title'],
                $item['Price'],
                $item['Description'],
                $item['Condition'],
                $item['Size'],
                $item['Brand'],
                $item['ImagePath'],
                $item['WishlistCounter']
            );
        }

        return $items;
    }

    static function searchItems(PDO $db, string $search, array $categories, array $conditions, string $min, string $max, string $order, int $limit): array
    {
        $sql = 'SELECT DISTINCT ITEM.ItemId, UserId, Title, Price, Description, Condition, 
            Size, Brand, ImagePath, WishlistCounter
            FROM ITEM';

        if (!empty($categories)) {
            $inClausePlaceholders = implode(',', array_fill(0, count($categories), '?'));
            $sql .= ' JOIN ITEM_CATEGORY ON ITEM.ItemId = ITEM_CATEGORY.ItemId 
                  JOIN CATEGORY ON ITEM_CATEGORY.CategoryId = CATEGORY.CategoryName 
                  WHERE CATEGORY.CategoryName IN (' . $inClausePlaceholders . ')';
        }
        $sql .= (!empty($categories) ? ' AND' : ' WHERE') . ' Price >= ? AND Price <= ?';

        if (!empty($conditions)) {
            $dennis = implode(',', array_fill(0, count($conditions), '?'));
            $sql .= ' AND Condition IN (' . $dennis . ')';
        }

        if (!empty($search)) {
            $sql .= ' AND Title LIKE ?';
        }

        $sql .= match ($order) {
            'desc' => ' ORDER BY Price DESC ',
            'asc' => ' ORDER BY Price ASC ',
            default => ' ORDER BY WishlistCounter DESC ',
        };

        $sql .= ' LIMIT ?';
        $stmt = $db->prepare($sql);

        $paramIndex = 1;

        // Bind parameters
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $stmt->bindValue($paramIndex++, $category);
            }
        }

        $stmt->bindValue($paramIndex++, $min);
        $stmt->bindValue($paramIndex++, $max);

        if (!empty($conditions)) {
            foreach ($conditions as $condition) {
                $stmt->bindValue($paramIndex++, $condition);
            }
        }

        if (!empty($search)) {
            $stmt->bindValue($paramIndex++, $search . '%');
        }

        $stmt->bindValue($paramIndex++, $limit, PDO::PARAM_INT);

        $stmt->execute();

        $items = [];
        while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item(
                $item['ItemId'],
                $item['UserId'],
                $item['Title'],
                $item['Price'],
                $item['Description'],
                $item['Condition'],
                $item['Size'],
                $item['Brand'],
                $item['ImagePath'],
                $item['WishlistCounter']
            );
        }
        return $items;
    }

    static function getItem(PDO $db, int $id): Item
    {
        $stmt = $db->prepare('SELECT ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter FROM ITEM WHERE ItemId = ?');
        $stmt->execute(array($id));

        $item = $stmt->fetch();

        return new Item(
            $item['ItemId'],
            $item['UserId'],
            $item['Title'],
            $item['Price'],
            $item['Description'],
            $item['Condition'],
            $item['Size'],
            $item['Brand'],
            $item['ImagePath'],
            $item['WishlistCounter']
        );
    }

    static function getMaxPrice(PDO $db): float
    {
        $stmt = $db->prepare('SELECT MAX(PRICE) AS MaxPrice FROM ITEM');
        $stmt->execute();
        return (float)$stmt->fetch(PDO::FETCH_ASSOC)['MaxPrice'];

    }

    static function getItemSuggestions(PDO $db, string $text)
    {
        $searchTerm = "%$text%";
        $stmt = $db->prepare('SELECT ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter FROM ITEM WHERE Title LIKE ? OR Description LIKE ? OR Brand LIKE ? LIMIT 5');
        $stmt->execute(array($searchTerm, $searchTerm, $searchTerm));

        $items = array();
        while ($item = $stmt->fetch()) {
            $items[] = new Item(
                $item['ItemId'],
                $item['UserId'],
                $item['Title'],
                $item['Price'],
                $item['Description'],
                $item['Condition'],
                $item['Size'],
                $item['Brand'],
                $item['ImagePath'],
                $item['WishlistCounter']
            );
        }

        return $items;
    }

    static function getAdds(PDO $db, int $userId, int $count, int $offset): array
    {
        $stmt = $db->prepare('SELECT ItemId, UserId, Title, Price, Description, Condition, 
            Size, Brand, ImagePath, WishlistCounter FROM ITEM WHERE UserId = ? LIMIT ? OFFSET ?');
        $stmt->execute(array($userId, $count, $offset));

        $items = array();
        while ($item = $stmt->fetch()) {
            $items[] = new Item(
                $item['ItemId'],
                $item['UserId'],
                $item['Title'],
                $item['Price'],
                $item['Description'],
                $item['Condition'],
                $item['Size'],
                $item['Brand'],
                $item['ImagePath'],
                $item['WishlistCounter']
            );
        }

        return $items;
    }

    static function getWishlist(PDO $db, int $userId, int $count, int $offset): array
    {
        $stmt = $db->prepare('SELECT ITEM.ItemId, ITEM.UserId, Title, Price, Description, Condition, 
            Size, Brand, ImagePath, WishlistCounter FROM ITEM JOIN WISHLIST ON ITEM.ItemId = WISHLIST.ItemId 
            WHERE WISHLIST.UserId = ? LIMIT ? OFFSET ?');
        $stmt->execute(array($userId, $count, $offset));

        $items = array();
        while ($item = $stmt->fetch()) {
            $items[] = new Item(
                $item['ItemId'],
                $item['UserId'],
                $item['Title'],
                $item['Price'],
                $item['Description'],
                $item['Condition'],
                $item['Size'],
                $item['Brand'],
                $item['ImagePath'],
                $item['WishlistCounter']
            );
        }

        return $items;
    }

    static function isInWishlist(PDO $db, int $userId, int $itemId): bool
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM WISHLIST WHERE UserId = ? AND ItemId = ?');
        $stmt->execute(array($userId, $itemId));

        $count = $stmt->fetchColumn();

        return $count > 0;
    }
}

?>