<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/image.class.php');
require_once(__DIR__ . '/../../private/database/user.class.php');
require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/profile.tpl.php');

$db = getDatabaseConnection();

$userId = isset($_GET['id']) ? $_GET['id'] : null;
if($userId === null) {
    if($session->isLoggedIn()) {
        $userId = $session->getId();
    }
    else {
        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        $redirectUrl .= (!str_contains($redirectUrl, '?') ? '?' : '&') . 'showLogin=true';
        header("Location: " . $redirectUrl);
        exit();
    }
}

$userId = intval($userId);
$user = User::getUser($db, $userId);

drawHeader($db, $session);
drawProfileBody("personal_information", $userId);
drawPersonalInformationBody($db, $user);

drawFooter();
?>