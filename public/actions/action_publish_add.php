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
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');


try {
    header('Location: ' . $_SERVER['HTTP_REFERER']);

    $db = getDatabaseConnection();
    $userId = $session->getId();

    if (isset($_POST['csrf'])) {
        $csrf = $_POST['csrf'];


        if ($csrf === $session->getToken()) {

            if (isset($_POST['title'])) {
                $title = htmlspecialchars($_POST['title']);
            } else {
                $session->addMessage('error', 'No title provided');
                exit();
            }

            if (isset($_POST['price'])) {
                $price = floatval($_POST['price']);

            } else {
                $session->addMessage('error', 'No price provided');
                exit();
            }

            if (isset($_POST['description'])) {
                $description = htmlspecialchars($_POST['description']);

            } else {
                $session->addMessage('error', 'No description provided');
                exit();
            }

            if (isset($_POST['condition'])) {
                $condition = htmlspecialchars($_POST['condition']);
            } else {
                $session->addMessage('error', 'No condition provided');
                exit();
            }
            if (isset($_POST['size'])) {
                $size = htmlspecialchars($_POST['size']);

            } else {
                $session->addMessage('error', 'No size provided');
                exit();
            }
            if (isset($_POST['brand'])) {
                $brand = htmlspecialchars($_POST['brand']);
            } else {
                $session->addMessage('error', 'No brand provided');
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
                    } //add the else clause
                }

                $db->beginTransaction();
                if (Item::addItem($db, $userId, $title, $price, $description, $condition, $size, $brand, $imagePaths[0])) {
                    $itemId = $db->lastInsertId();
                    $db->commit();

                    for ($i = 1; $i < count($imagePaths); $i++) {
                        $imagePath = $imagePaths[$i];

                        if (!Image::addImage($db, (int)$itemId, $imagePath)) {
                            $session->addMessage('error', "Failed to add files");
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                            exit();
                        }
                    }

                    header('Location: ../pages/item.php?id=' . $itemId);
                    exit();

                } else {
                    $db->rollBack();
                    $session->addMessage('error', "Failed to add files");

                }

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
    $session->addMessage('error', 'A database error occurred. Please try again later.');

} catch (Exception $e) {
    $session->addMessage('error', 'An error occurred. Please try again later.');
}

?>