<?php
declare(strict_types=1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');

try {
    $db = getDatabaseConnection();

    $searchTerm = $_GET['search'] ?? '';

    $items = Item::getItemSuggestions($db, $searchTerm);

    $result = array();

    foreach ($items as $item) {
        $itemSuggestions = [
            'itemId' => $item->itemId,
            'title' => $item->title,
            'image' => $item->imagePath
        ];

        $result[] = $itemSuggestions;
    }

    header('Content-Type: application/json');
    echo json_encode($result);
} catch (Exception $e) {
    error_log('Error in api_suggestions.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}