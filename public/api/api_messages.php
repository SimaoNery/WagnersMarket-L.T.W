<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
    handleBadAccess("You don't have permission to access this page!", $session);
    exit();
}


require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/message.class.php');

try {
    $db = getDatabaseConnection();
    $user = $session->isLoggedIn() ? $session->getId() : null;
    $otherUser = isset($_GET['otherUser']) ? intval($_GET['otherUser']) : null;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : null;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : null;

    $messages = Message::getConversation($db, $user, $otherUser, $limit, $offset);

    header('Content-Type: application/json');
    echo json_encode($messages);
} catch (Exception $e) {
    error_log('Error in api_messages.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}