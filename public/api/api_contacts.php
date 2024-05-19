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
require_once(__DIR__ . '/../../private/database/user.class.php');

try {
    $db = getDatabaseConnection();
    $userId = $session->getId();
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : null;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : null;

    $contacts = Message::getLastMessages($db, $userId, $limit, $offset);
    $profilePics = [];
    $usernames = [];
    $otherIds = [];
    foreach ($contacts as $contact) {
        $user = $contact->receiverId === $userId ? User::getUser($db, $contact->authorId) : User::getUser($db, $contact->receiverId);
        $profilePics[] = $user->profilePic;
        $usernames[] = $user->username;
        $otherIds[] = $user->userId;
    }

    $finalResponse = [
        'contacts' => $contacts,
        'profilePics' => $profilePics,
        'usernames' => $usernames,
        'otherIds' => $otherIds
    ];

    header('Content-Type: application/json');
    echo json_encode($finalResponse);
} catch (Exception $e) {
    error_log('Error in api_contacts.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}
