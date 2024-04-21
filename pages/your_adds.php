<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/item.tpl.php');
require_once(__DIR__ . '/../templates/profile.tpl.php');


$limit = 8;
$offset = 0;
$userId = intval($_GET['id']);
$db = getDatabaseConnection();
$items = Item::getAdds($db, $userId, $limit, $offset);

drawHeader();
drawProfileBody("your-adds", $userId);
drawItems("",$items);
drawFooter();
?>