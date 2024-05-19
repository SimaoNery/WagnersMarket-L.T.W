<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    exitWithError($session, "User not logged in");
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');
require_once(__DIR__ . '/../../private/database/message.class.php');

$db = getDatabaseConnection();
$userId = $session->getId();
$otherUserId = intval($_POST['other-user-id']) ?? exitWithError($session,"Missing receiver of message");
$message = $_POST['message'] ?? exitWithError($session,"Missing message");

if (Message::addMessage($db, $userId, $otherUserId, $message)) {
    $session->addMessage('success', 'Message sent');
} else {
    $session->addMessage('error', 'Message not sent');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

function exitWithError($session, string $error): void
{
    $session->addMessage('error', $error);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

