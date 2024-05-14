<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/cart.class.php');
require_once(__DIR__ . '/../../private/database/item.class.php');

$db = getDatabaseConnection();
$userId = $session->getId();
$limit = 4;
$offset = 0;

$newItem = Item::getItem($db, intval($_GET['id']));


if(Cart::addToShoppingBag($db, $userId, $newItem->itemId)) {
    $session->addMessage('success', 'Item Added Successfully To Shopping Bag!');
} else {
    $session->addMessage('error', 'Item Not Added To Shopping Bag!');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

?>