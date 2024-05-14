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
    $search = $_GET['search'] ?? "";
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 0;
    $offset =  isset($_GET['offset']) ? intval($_GET['offset']) : 0;

    $users = User::getUserByAnything($db, $search, $limit, $offset);


    header('Content-Type: application/json');
    echo json_encode($users);
} catch (Exception $e) {
    error_log('Error in api_contacts.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}
