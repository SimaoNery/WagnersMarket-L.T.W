<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/wishlist.class.php');
require_once(__DIR__ . '/../../private/database/item.class.php');



try {
    $db = getDatabaseConnection();
    $userId = $session->getId();

    $itemId = intval($_POST['itemId']);

    if(Wishlist::removeFromWishlist($db, $userId, $itemId)) {
        Item::decrementWishlistCounter($db, $itemId);
        $session->addMessage('success', 'Item successfully removed from wishlist!');
    } else {
        $success = false;
        $session->addMessage('error', 'Item not removed from wishlist!');
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => 'Operation done successfully.']);

} catch (Exception $e) {
    error_log('Error in api_remove_from_wishlist.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}
?>