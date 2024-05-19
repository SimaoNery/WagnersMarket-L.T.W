<?php
declare(strict_types = 1);

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

    $search = $_GET['search'];
    $categories = empty($_GET['category']) ? [] : explode(';', $_GET['category']);
    $conditions = empty($_GET['condition']) ? [] : explode(';', $_GET['condition']);
    $min = $_GET['min'];
    $max = $_GET['max'];
    $order = $_GET['order'];
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : null;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : null;

    $items = Item::searchItems($db, $search, $categories, $conditions, $min, $max, $order, $limit, $offset);

    header('Content-Type: application/json');
    echo json_encode($items);

} catch (Exception $e) {
    error_log('Error in api_items.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}

?>