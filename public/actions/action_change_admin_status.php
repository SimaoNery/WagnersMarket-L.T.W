<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
    exit();
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/user.class.php');
require_once(__DIR__ . '/action_utils.php');

try {
    $db = getDatabaseConnection();
    $response = [];

    if (isset($_POST['csrf'])) {
        $csrf = urldecode($_POST['csrf']);

        if ($csrf === $session->getToken()) {

            if (isset($_POST['userId'])) {
                $userId = intval($_POST['userId']);
            } else {
                throw new Exception('userId is not set.');
            }
            if(isset($_POST['isAdmin'])) {
                $isAdmin = boolval($_POST['isAdmin']);
            } else {
                throw new Exception('isAdmin is not set.');
            }

            if (User::changeAdminStatus($db,$userId, $isAdmin)) {
                $response = ['success' => 'User\'s admin status changed.'];
            } else {
                $response = ['error' => 'An error occurred! Not able to change user\'s admin status.'];
            }

        } else {
            $response = ['error' => 'An error occurred! The tokens do not match.'];
        }
    } else {
        $response = ['error' => 'An error occurred! Couldn\'t get token.'];
    }

    handleResponse($response, $session);

} catch (PDOException $e) {
    $response = ['error' => 'A database error occurred. Please try again later.'];

    handleResponse($response, $session);

} catch (Exception $e) {

    $response = ['error' => 'An error occurred. Please try again later.'];

    handleResponse($response, $session);
}





