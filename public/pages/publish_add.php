<?php
declare(strict_types = 1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/category.class.php');
require_once(__DIR__ . '/../../private/database/size.class.php');
require_once(__DIR__ . '/../../private/database/condition.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/publish.tpl.php');


$limit = 4;
$offset = 0;
$db = getDatabaseConnection();

$categories = Category::getCategories($db);
$sizes = Size::getSizes($db);
$conditions = Condition::getConditions($db);

/*drawHeader($db, $session);*/
drawPublishForm($categories, $sizes, $conditions);
drawFooter();
?>