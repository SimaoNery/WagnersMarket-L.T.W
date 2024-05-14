<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/user.class.php');

try {
    $db = getDatabaseConnection();
    $userId = intval($_POST['userId']);
    $success = true;

    if (User::deleteUser($db,$userId)) $session->addMessage('error', 'User deleted.');
    else {
        $session->addMessage('error', 'Not able to delete user.');
        $success = false;
    }


    header('Content-Type: application/json');
    $finalResponse = [
        'success' => $success ? '1' : '0',
    ];
    echo json_encode($success);
} catch (Exception $e) {
    error_log('Error in api_contacts.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}
