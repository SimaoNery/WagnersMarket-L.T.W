<?php
declare(strict_types = 1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header("Location: access_denied.php");
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/user.class.php');
require_once(__DIR__ . '/../../private/database/category.class.php');
require_once(__DIR__ . '/../../private/database/condition.class.php');
require_once(__DIR__ . '/../../private/database/size.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/admin.tpl.php');

$db = getDatabaseConnection();
$categories = Category::getCategories($db);
$sizes = Size::getSizes($db);
$conditions = Condition::getConditions($db);

drawHeader($db, $session);
drawTitle("Admin Board");
drawAdminBoard($categories, $conditions, $sizes);
drawFooter();
?>