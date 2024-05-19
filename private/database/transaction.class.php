<?php
declare(strict_types=1);

class Transaction {
    public static function create(PDO $db, int $buyerId, int $sellerId, float $price, string $address): int {
        $stmt = $db->prepare('INSERT INTO TRANSACTION (SellerId, BuyerId, Price, Address) VALUES (?, ?, ?, ?)');
        $stmt->execute([$sellerId, $buyerId, $price, $address]);

        return (int) $db->lastInsertId();
    }

    public static function addItemToTransaction(PDO $db, int $transactionId, int $itemId): bool {
        $stmt = $db->prepare('INSERT INTO TRANSACTION_ITEM (TransactionId, ItemId) VALUES (?, ?)');
        return $stmt->execute([$transactionId, $itemId]);
    }
}
?>
