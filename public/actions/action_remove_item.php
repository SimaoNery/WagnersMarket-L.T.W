<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');

$db = getDatabaseConnection();
$userId = $session->getId();

$items = Item::getShoppingBag($db, $userId);

foreach($items as $item) {
    if (Item::deleteItem($db, $item->itemId)) {
        $session->addMessage('success', 'Item Removed Successfully!');
    } else {
        $session->addMessage('error', 'Item Not Removed!');
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
