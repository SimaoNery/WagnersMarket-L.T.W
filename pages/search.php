<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/item.tpl.php');

$limit = 16;
$offset = 0;

$db = getDatabaseConnection();
$items = Item::getItems($db, $limit, $offset);
$numItems = Item::getNumItems($db);
$maxPrice = Item::getMaxPrice($db);


drawHeader();
drawSearchBar("searchItems");
drawItems("Featured Items",$items);
drawItemFilter($maxPrice, $items);
drawItemSorter();
drawFooter();
?>