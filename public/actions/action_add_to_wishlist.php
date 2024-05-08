<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    //SENDS A POPUP -> PAULO IS DOING
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/wishlist.class.php');
require_once(__DIR__ . '/../../private/database/item.class.php');

$db = getDatabaseConnection();
$userId = $session->getId();
$limit = 4;
$offset = 0;

$newItem = Item::getItem($db, intval($_GET['id']));


if(Wishlist::addToWishlist($db, $userId, $newItem->itemId)) {
    Item::incrementWishlistCounter($db, $newItem->itemId);
    $session->addMessage('success', 'Item Added Successfully To Wishlist!');
} else {
    $session->addMessage('error', 'Item Not Added To Wishlist!');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

?>