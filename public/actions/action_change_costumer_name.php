<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/user.class.php');

if (!$session->isLoggedIn()) {
    exit;
}

$db = getDatabaseConnection();

$userId = $session->getId(); 

$name = htmlspecialchars($_POST['name']) ?? exitWithError($session, "Name not provided");

if (User::changeName($db, $userId, $name)) {
    $session->addMessage('success', 'Name changed');
} else {
    $session->addMessage('error', 'Error changing name');
}


header('Location: ' . $_SERVER['HTTP_REFERER']);
?>