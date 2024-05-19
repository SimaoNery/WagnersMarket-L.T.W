<?php
declare(strict_types=1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
    handleBadAccess("You don't have permission to access this page!", $session);
    exit();
}


require_once(__DIR__ . '/action_utils.php');
require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/action_utils.php');



    $db = getDatabaseConnection();
    $response = [];

    if (isset($_POST['csrf'])) {
        $csrf = urldecode($_POST['csrf']);

        if ($csrf === $session->getToken()) {

            if (isset($_POST['itemId'])) {
                $itemId = intval($_POST['itemId']);
            } else {
                throw new Exception('Item was not given.');
            }

            if(Item::deleteItem($db, $itemId)) {
                $response = ['success' => 'The item was successfully removed.'];
            } else {
                $response = ['error' => 'An error occurred! The item could not be removed.'];
            }

        }

        else {
            $response = ['error' => 'An error occurred! The tokens do not match.'];
        }
    }
    else {
        $response = ['error' => 'An error occurred! Couldn\'t get token.'];
    }

    handleResponse($response, $session);

