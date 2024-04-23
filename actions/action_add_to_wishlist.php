<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) die(header('Location: /'));

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/wishlist.class.php');
require_once(__DIR__ . '/../database/item.class.php');

$db = getDatabaseConnection();
$userId = $session->getId();
$limit = 4;
$offset = 0;

$wishlist = Item::getWishlist($db, $userId, $limit, $offset);
$newItem = Item::getItem($db, intval($_POST['id']));
$flag = false; //flag to check if item is already in the wishlist

foreach ($wishlist as $item) {
    if ($item == $newItem) {
        $flag = true;
        break;
    }
}

if(!$flag) {
    addToWishlist($db, $userId, $newItem->itemId);
}