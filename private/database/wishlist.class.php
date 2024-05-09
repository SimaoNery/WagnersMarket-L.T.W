<?php
declare(strict_types=1);

class Wishlist
{
    public int $userId;
    public int $itemId;

    public function __construct(int $userId, int $itemId)
    {
        $this->userId = $userId;
        $this->itemId = $itemId;
    }

    static function addToWishlist(PDO $db, int $userId, int $itemId)
    {
        $stmt = $db->prepare("INSERT INTO WISHLIST (userId, itemId) VALUES (?, ?)");
        $stmt->execute(array($userId, $itemId));


        return $stmt->rowCount() > 0;
    }

    static function removeFromWishlist(PDO $db, int $userId, int $itemId)
    {
        $stmt = $db->prepare("DELETE FROM WISHLIST WHERE userId = ? and itemId = ?");
        $stmt->execute(array($userId, $itemId));

        return $stmt->rowCount() > 0;
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