<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
    handleBadAccess("You don't have permission to access this page!", $session);
    exit();
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/category.class.php');
require_once(__DIR__ . '/action_utils.php');

try {
    $db = getDatabaseConnection();
    $response = [];

    if (isset($_POST['csrf'])) {
        $csrf = $_POST['csrf'];

        if ($csrf === $session->getToken()) {

            if (isset($_POST['category'])) {
                $category = $_POST['category'];
            } else {
                throw new Exception('Category is not set.');
            }
            if (isset($_FILES['image'])) {
                $image = $_FILES['image'];
                $fileName = $image['tmp_name'];
                $targetDir = "../images/";
                $targetPath = $targetDir . basename($image['name']);
            } else {
                throw new Exception('Category image is not set.');
            }

            if (move_uploaded_file($fileName, $targetPath)) {
                if (Category::addCategory($db, $category, $targetPath)) {
                    $response = ['success' => 'The category was successfully added.', 'imagePath' => $targetPath];
                }
                else {
                    $response = ['error' => 'An error occurred! The provided category already exists.'];
                }
            } else {
                $response = ['error', 'An error occurred while uploading the image file.'];
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



