<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/category.class.php');

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/item.tpl.php');
require_once(__DIR__ . '/../templates/category.tpl.php');
require_once(__DIR__ . '/../templates/home.tpl.php');

$db = getDatabaseConnection();
$categories = Category::getCategories($db);
$items = Item::getItems($db, 8);


drawHeader();
drawHomeBody();
drawCategories($categories);
drawItems($items, $db);
drawFooter();
?>