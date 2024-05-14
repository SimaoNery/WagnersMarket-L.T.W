<?php
declare(strict_types=1);

class Cart
{
    public int $userId;
    public int $itemId;

    public function __construct(int $userId, int $itemId)
    {
        $this->userId = $userId;
        $this->itemId = $itemId;
    }

    static function addToShoppingBag(PDO $db, int $userId, int $itemId)
    {
        $stmt = $db->prepare("INSERT INTO CART (userId, itemId) VALUES (?, ?)");
        $stmt->execute(array($userId, $itemId));


        return $stmt->rowCount() > 0;
    }

    static function removeFromShoppingBag(PDO $db, int $userId, int $itemId)
    {
        $stmt = $db->prepare("DELETE FROM CART WHERE userId = ? and itemId = ?");
        $stmt->execute(array($userId, $itemId));

        return $stmt->rowCount() > 0;
    }

    static function isInShoppingBag(PDO $db, int $userId, int $itemId): bool
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM CART WHERE UserId = ? AND ItemId = ?');
        $stmt->execute(array($userId, $itemId));

        $count = $stmt->fetchColumn();

        return $count > 0;
    }
}

?>