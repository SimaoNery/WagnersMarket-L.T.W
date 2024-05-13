<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();



require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/image.class.php');
require_once(__DIR__ . '/../../private/database/user.class.php');
require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/profile.tpl.php');

if(!$session->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$db = getDatabaseConnection();

$userId = $session->getId();

$user = User::getUser($db, $userId);

drawHeader($db, $session);
drawProfileBody("personal_information", $userId);
drawPersonalInformationBody($db, $user);

drawFooter();
?>