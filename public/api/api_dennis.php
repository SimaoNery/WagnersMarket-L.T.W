<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');

try {
    $db = getDatabaseConnection();

    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : null;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : null;

    $numItems = Item::getNumItems($db);
    $items = Item::getItems($db, $limit, $offset);

    $finalResponse = [
        'items' => $items,
        'totalCount' => $numItems
    ];

    header('Content-Type: application/json');
    echo json_encode($finalResponse);
} catch (Exception $e) {
    error_log('Error in api_items.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}