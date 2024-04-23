<?php
    declare(strict_types = 1);

    class Wishlist {
        public int $userId;
        public int $itemId;

        public function __construct(int $userId, int $itemId)
        {
            $this->userId = $userId;
            $this->itemId = $itemId;
        }
    }

    static function addToWishlist(PDO $db, int $userId, int $itemId) {
        $stmt = $db->prepare("INSERT INTO WISHLIST (userId, itemId) VALUES (?, ?)");
    }

?>