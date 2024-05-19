<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    exitWithError($session, "User not logged in");
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');
require_once(__DIR__ . '/../../private/database/message.class.php');

try {
    $db = getDatabaseConnection();
    $userId = $session->getId();
    $otherUserId = isset($_POST['other-user-id']) ? intval($_POST['other-user-id']) : exitWithError($session, "Missing receiver of message");
    $message = $_POST['message'] ?? exitWithError($session, "Missing message");

    $result = Message::addMessage($db, $userId, $otherUserId, $message);

    if ($result) {
        $session->addMessage('success', 'Message sent');
    } else {
        $session->addMessage('error', 'Message not sent');
    }

    header('Content-Type: application/json');
    echo json_encode($result);

} catch (Exception $e) {
    error_log('Error in action_send_message.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}
