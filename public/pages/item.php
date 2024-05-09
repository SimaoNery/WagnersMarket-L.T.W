<?php
declare(strict_types = 1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');
require_once(__DIR__ . '/../../private/database/wishlist.class.php');
require_once(__DIR__ . '/../../private/database/user.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/item.tpl.php');

$db = getDatabaseConnection();

$item = Item::getItem($db, intval($_GET['id']));
$images = Image::getImages($db, $item->itemId);
$loggedIn = $session->isLoggedIn();
$inWishList = Wishlist::isInWishlist($db, $session->getId(),$item->itemId);
$user = User::getUser($db, $session->getId());

drawHeader($db, $session);
drawItem($item, $images, $loggedIn, $inWishList, $user);
drawFooter();
?>