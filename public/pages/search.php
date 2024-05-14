<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/item_category.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/item.tpl.php');

$limit = 16;
$offset = 0;

$db = getDatabaseConnection();

$categoryName = isset($_GET['category']) ? $_GET['category'] : null;


$items = Item::getMostPopularItems($db, $limit, $offset);
$numItems = Item::getNumItems($db);
$maxPrice = Item::getMaxPrice($db);

drawHeader($db, $session);
drawSearchBar("searchItems", "What are you looking for?");
drawTitle("Featured Items");
drawItems($db, $items, $session->isLoggedIn(), $session);
drawItemFilter($db, $maxPrice, $categoryName);
drawItemSorter();
drawFooter();
?>