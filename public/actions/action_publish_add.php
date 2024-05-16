<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');

$db = getDatabaseConnection();
$userId = $session->getId();

$title = htmlspecialchars($_POST['title']) ?? exitWithError($session, "Title not provided");
$price = floatval($_POST['price'] ?? 0) ?? exitWithError($session, "Price not provided");
$description = htmlspecialchars($_POST['description']) ?? exitWithError($session, "Description not provided");
$condition = htmlspecialchars($_POST['condition']) ?? exitWithError($session, "Condition not provided");
$size = htmlspecialchars($_POST['size']) ?? exitWithError($session, "Size not provided");
$brand = htmlspecialchars($_POST['brand']) ?? exitWithError($session, "Brand not provided");
$images = $_FILES['images'] ?? exitWithError($session, "No cover image provided");

$imagePaths = [];
foreach ($images['tmp_name'] as $index => $tmpName) {
    if ($images['error'][$index] !== UPLOAD_ERR_OK) {
        $targetDir = '../../public/images/';
        $targetPath = $targetDir . basename($images['name'][$index]);
        if (move_uploaded_file($tmpName, $targetPath)) {
            $imagePaths[] = $targetPath;
        } else {
            exitWithError($session, "Failed to move uploaded file");
        }
    } else {
        exitWithError($session, "Failed to upload file");
    }
}


try {
    $db->beginTransaction();
    if (Item::addItem($db, $userId, $title, $price, $description, $condition, $size, $brand, $imagePaths[0])) {
        $itemId = $db->lastInsertId();
        $db->commit();

        for ($i = 1; $i < count($imagePaths); $i++) {
            $imagePath = $imagePaths[$i];

            if (!Image::addImage($db, (int)$itemId, $imagePath)) {
                exitWithError($session, "Failed to add image");
            };
        }

        header('Location: ../pages/item.php?id=' . $itemId);
        exit();

    } else {
        $db->rollBack();
        exitWithError($session, "Failed to add item");
    }

}catch (Exception $e) {
        $db->rollBack();
        exitWithError($session, "An error occurred: " . $e->getMessage());
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

function exitWithError($session, string $error): void
{
    $session->addMessage('error', $error);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

?>