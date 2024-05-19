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
require_once(__DIR__ . '/../../private/database/wishlist.class.php');

try {
    $db = getDatabaseConnection();
    $itemId = $_GET['itemId'];
    $itemId = isset($_GET['itemId']) ? (int)$_GET['itemId'] : 0;

    $isInWishlist = Wishlist::isInWishlist($db, $session->getId(), $itemId);

    header('Content-Type: application/json');
    echo json_encode($isInWishlist);
} catch (Exception $e) {
    error_log('Error in api_is_in_wishlist.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}