<?php
declare(strict_types = 1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/access_denied.tpl.php');

?>
<h1>Sorry, but you don't have access to this page...</h1>
<img src="../images/denied.png">
