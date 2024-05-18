<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/message.class.php');
require_once(__DIR__ . '/../../private/database/user.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/profile.tpl.php');
require_once(__DIR__ . '/../../private/templates/messages.tpl.php');


$limit = 20;
$offset = 0;
$db = getDatabaseConnection();

$userId = $session->getId();
$lastMessages = Message::getLastMessages($db, $userId, $limit, $offset);

$otherUserId = $_GET['otherUserId'] ?? -1;
$otherUserId = intval($otherUserId);

$messages = ($otherUserId === -1) ?  [] : Message::getConversation($db, $userId, $otherUserId, $limit, $offset);

if ($otherUserId === -1 && !empty($lastMessages)) {
    $otherUserId = $lastMessages[0]->authorId === $userId ? $lastMessages[0]->receiverId : $lastMessages[0]->authorId;
    $messages = Message::getConversation($db, $userId, $otherUserId, $limit, $offset);

}


drawHeader($db, $session);
drawProfileBody("messages", $userId);
drawMessages($lastMessages, $messages, $db, $userId, $otherUserId);
drawFooter();
?>

