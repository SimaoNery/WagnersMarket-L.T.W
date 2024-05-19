<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
    exit();
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/size.class.php');
require_once(__DIR__ . '/action_utils.php');

try {
    $db = getDatabaseConnection();
    $response = [];

    if (isset($_POST['csrf'])) {
        $csrf = urldecode($_POST['csrf']);

        if ($csrf === $session->getToken()) {

            if (isset($_POST['size'])) {
                $size = $_POST['size'];
            } else {
                throw new Exception('Size is not set.');
            }

            if (Size::addSize($db, $size)) {
                $response = ['success' => 'The package size was successfully added.'];
            }
            else {
                $response = ['error' => 'An error occurred! The provided package size already exists.'];
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


