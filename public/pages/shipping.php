<?php
declare(strict_types = 1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/shipping.tpl.php');

$db = getDatabaseConnection();

drawHeader($db, $session);
drawTitle("Shipping Form");
drawDate();
drawShipping();
drawFooter();
?>