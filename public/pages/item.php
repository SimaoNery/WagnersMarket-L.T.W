<?php
declare(strict_types = 1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');
require_once(__DIR__ . '/../../private/database/wishlist.class.php');
require_once(__DIR__ . '/../../private/database/user.class.php');
require_once(__DIR__ . '/../../private/database/cart.class.php');


require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/item.tpl.php');

$db = getDatabaseConnection();


$item = Item::getItem($db, intval($_GET['id']));
$images = Image::getImages($db, $item->itemId);

if($session->isLoggedIn()) {
    $inWishList = Wishlist::isInWishlist($db, $session->getId(),$item->itemId);
    $inShoppingBag = Cart::isInShoppingBag($db, $session->getId(),$item->itemId);
} else {
    $inWishList = false;
    $inShoppingBag = false;
}

$user = User::getUser($db, $item->userId);

drawHeader($db, $session);
drawItem($db,$item, $images, $session, $user);
drawFooter();
?>