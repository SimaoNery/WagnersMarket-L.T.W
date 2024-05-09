<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/image.class.php');

$db = getDatabaseConnection();
$userId = $session->getId();

$title = $_POST['title'];
$price = floatval($_POST['price']);
$description = $_POST['description'];
$condition = $_POST['condition'];
$size = $_POST['size'];
$brand = $_POST['brand'];
$images = $_FILES['images'];

$imagePaths = [];
foreach ($images['tmp_name'] as $index => $tmpName) {
    if ($images['error'][$index] === UPLOAD_ERR_OK) {
        $targetDir = '../../public/images/';
        $targetPath = $targetDir . basename($images['name'][$index]);
        if (move_uploaded_file($tmpName, $targetPath)) {
            $imagePaths[] = $targetPath;
        } else {
            $session->addMessage('error', 'Error moving uploaded file.');
        }
    } else {
        $session->addMessage('error', 'Error uploading file.');
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
                $session->addMessage('error', 'Error adding images');
            };
        }
    } else {
        $db->rollBack();

        $session->addMessage('error', 'Item Not Added!');
    }

}catch (Exception $e) {
        $db->rollBack();

        $session->addMessage('error', 'An error occurred: ' . $e->getMessage());
}


header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();

?>