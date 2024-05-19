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

header('Location: ' . $_SERVER['HTTP_REFERER']);

try {


    $db = getDatabaseConnection();
    $response = [];

    if (isset($_POST['csrf'])) {
        $csrf = $_POST['csrf'];

        if ($csrf === $session->getToken()) {
            if(isset($_FILES['image'])) {
                $image = $_FILES['image'];
                $fileName = $image['tmp_name'];
                $targetDir = "../images/";
                $targetPath = $targetDir . basename($image['name']);
            } else {
                throw new Exception('New image wasn\'t provided');
            }

            if (move_uploaded_file($fileName, $targetPath)) {
                if (User::changeProfilePic($db, $session->getId(), $targetPath)) {
                    $session->addMessage('success', 'Your profile picture was successfully changed.');

                }
                else {
                    $session->addMessage('error', 'An error occurred! Your profile picture couldn\'t be changed.');
                }
            } else {
                $session->addMessage('error', 'An error occurred while uploading the image file.');
            }


        } else {
            $session->addMessage('error', 'An error occurred! The tokens do not match.');
        }
    } else {
        $session->addMessage('error', 'An error occurred! Couldn\'t get token.');
    }

} catch (PDOException $e) {
    $session->addMessage('error', 'A database error occurred. Please try again later.');

} catch (Exception $e) {
    $session->addMessage('error', 'An error occurred. Please try again later.');
}




