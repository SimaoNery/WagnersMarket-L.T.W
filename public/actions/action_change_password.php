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

$password = htmlspecialchars($_POST['password']) ?? exitWithError($session, "Password not provided");
$newPassword = htmlspecialchars($_POST['new-password']) ?? exitWithError($session, "New password not provided");

$customer = User::getUserWithIdAndPassword($db, $userId, $password);


if ($customer) {
    if (User::changePassword($db, $userId, $newPassword)) {
        $session->addMessage('success', 'Password changed');
    }
    else {
        $session->addMessage('error', 'Error changing password');
    }
} else {
    $session->addMessage('error', 'Wrong password!');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>