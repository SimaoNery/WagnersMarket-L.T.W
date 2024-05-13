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

$email = htmlspecialchars($_POST['email']) ?? exitWithError($session, "Email not provided");

if (User::getUserByEmail($db, $email)) {
    $session->addMessage('error', 'Email already in use');
} else {
    if (User::changeEmail($db, $userId, $email)) {
        $session->addMessage('success', 'Email changed');
    } else {
        $session->addMessage('error', 'Error changing email');
    }
}


header('Location: ' . $_SERVER['HTTP_REFERER']);
?>