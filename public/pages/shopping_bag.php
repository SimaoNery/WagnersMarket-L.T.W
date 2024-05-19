<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/cart.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/item.tpl.php');
require_once(__DIR__ . '/../../private/templates/profile.tpl.php');
require_once(__DIR__ . '/../../private/templates/shoppingBag.tpl.php');

$db = getDatabaseConnection();

$userId = $session->getId();
$items = Item::getShoppingBag($db, $userId);

$subTotal = 0;
$shippingCost = 0;

foreach($items as $item) {
    $subTotal += $item->price;
}

if ($subTotal <= 5) {
    $shippingCost = 5;
}
else if ($subTotal >= 100) {
    $shippingCost = 0;
}
else {
    $shippingCost = 5 + ($subTotal * 0.03);
    $shippingCost = min(15, $shippingCost);
}

$shippingCost = round($shippingCost, 2);

drawHeader($db, $session);
drawTitle("Shopping Cart");

if (count($items) > 0) {
    drawBag($db, $userId, $items);
    drawSummary($subTotal, $shippingCost);
}
else {
    drawEmpty("empty-shopping-bag", "Your shopping bag is empty!");
}

drawFooter();
?>

