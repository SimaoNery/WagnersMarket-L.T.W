<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
    handleBadAccess("You don't have permission to access this page!", $session);
    exit();
}


require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/item.tpl.php');
require_once(__DIR__ . '/../../private/templates/profile.tpl.php');


$limit = 16;
$offset = 0;
$db = getDatabaseConnection();

$userId = $session->getId();
$items = Item::getWishlist($db, $userId, $limit, $offset);
$numItems = Item::getNumItemsWishlist($db, $userId);

drawHeader($db, $session);
drawProfileBody("wishlist", $userId);

if($numItems === 0) {
    drawEmpty("empty-wishlist", "Your Wishlist is empty!");
} else {
    drawItems($db, $items, $session);
    drawPagination(intval(ceil($numItems / $limit)), "wishlist");
}
drawFooter();
?>

