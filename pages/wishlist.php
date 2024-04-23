<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    //SENDS A POPUP -> PAULO IS DOING
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/item.tpl.php');
require_once(__DIR__ . '/../templates/profile.tpl.php');


$limit = 8;
$offset = 0;
$db = getDatabaseConnection();

$userId = $session->getId();
$items = Item::getWishlist($db, $userId, $limit, $offset);
$numItems = Item::getNumItemsWishlist($db, $userId);

drawHeader($db, $session);
drawProfileBody("wishlist", $userId);
drawItems("Wishlist",$items);
drawPagination(intval(ceil($numItems / $limit))); //PAGINATION SEARCHING FOR MOST POPULAR
drawFooter();
?>