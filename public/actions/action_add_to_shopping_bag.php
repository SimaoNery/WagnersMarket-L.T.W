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

$itemId = intval($_POST['itemId']);

if(Cart::addToShoppingBag($db, $userId, $itemId)) {
    $session->addMessage('success', 'Item successfully added to shopping bag!');
} else {
    $success = false;
    $session->addMessage('error', 'Item not added to shopping bag!');
}

header('Content-Type: application/json');
echo json_encode(['success' => 'Operation done successfully.']);