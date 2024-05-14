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
    $isAdmin = boolval($_POST['isAdmin']);
    $success = true;
    if ($userId) {
        if (User::changeAdminStatus($db,$userId, $isAdmin)) $session->addMessage('error', 'Admin Status Changed');
        else {
            $session->addMessage('error', 'Not able to change admin status');
            $success = false;
        }
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
