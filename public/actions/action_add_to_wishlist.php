<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
    exit();
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/wishlist.class.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/action_utils.php');

try {
    $db = getDatabaseConnection();
    $response = [];

    if (isset($_POST['csrf'])) {
        $csrf = urldecode($_POST['csrf']);

        if ($csrf === $session->getToken()) {

            if (isset($_POST['itemId'])) {
                $itemId = intval($_POST['itemId']);
            } else {
                throw new Exception('Size is not set.');
            }

            if (Wishlist::addToWishlist($db, $session->getId(), $itemId)) {
                Item::incrementWishlistCounter($db, $itemId);
                $response = ['success' => 'Item added successfully to your wishlist.'];
            } else {
                $response = ['error' => 'An error occurred! Couldn\'t add the item to your your wishlist.'];
            }

        } else {
            $response = ['error' => 'An error occurred! The tokens do not match.'];
        }
    } else {
        $response = ['error' => 'An error occurred! Couldn\'t get token.'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    $response = ['error' => 'A database error occurred. Please try again later.'];

    header('Content-Type: application/json');
    echo json_encode($response);


} catch (Exception $e) {

    $response = ['error' => 'An error occurred. Please try again later.'];

    header('Content-Type: application/json');
    echo json_encode($response);

}






