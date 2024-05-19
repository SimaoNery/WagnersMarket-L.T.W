<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/access_denied.php');
    exit();
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');

header('Location: ' . $_SERVER['HTTP_REFERER']);
$db = getDatabaseConnection();

try {

    if (isset($_POST['csrf'])) {
        $csrf = $_POST['csrf'];


        if ($csrf === $session->getToken()) {

            if (isset($_POST['itemId'])) {
                $itemId = intval($_POST['itemId']);

            } else {
                $session->addMessage('error', 'No item provided');
                exit();
            }

            if (isset($_FILES['images'])) {
                $images = $_FILES['images'];

                $imagePaths = [];

                foreach ($images['tmp_name'] as $index => $tmpName) {
                    $targetDir = '../images/';
                    $targetPath = $targetDir . basename($images['name'][$index]);
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $imagePaths[] = $targetPath;
                    }
                }
                $db->beginTransaction();
                Item::changeItemImage($db, $itemId, $imagePaths[0]);
                Image::removeImages($db, $itemId);
                for ($i = 1; $i < count($imagePaths); $i++) {
                    $imagePath = $imagePaths[$i];

                    Image::addImage($db, (int)$itemId, $imagePath);
                }
                $db->commit();


            } else {
                throw new Exception('No images were provided');
            }

        } else {
            $session->addMessage('error', 'An error occurred! The tokens do not match.');
        }
    } else {
        $session->addMessage('error', 'An error occurred! Couldn\'t get token.');
    }

} catch (PDOException $e) {
    $db->rollBack();
    $session->addMessage('error', 'A database error occurred. Please try again later.');

} catch (Exception $e) {
    $session->addMessage('error', 'An error occurred. Please try again later.');
}
?>