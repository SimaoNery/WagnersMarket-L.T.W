<?php
declare(strict_types = 1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/category.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/category.tpl.php');
require_once(__DIR__ . '/../../private/templates/item.tpl.php');
require_once(__DIR__ . '/../../private/templates/home.tpl.php');


$limit = 4;
$offset = 0;
$db = getDatabaseConnection();

$categories = Category::getCategories($db);
$items = Item::getItems($db, $limit, $offset);
$numItems = Item::getNumItems($db);

drawHeader($db, $session);
drawHomeBody();
drawCategories($categories);
drawItems("Most popular", $items);
drawPagination(intval(ceil($numItems / $limit)));
drawFooter();
?>