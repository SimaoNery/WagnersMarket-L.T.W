<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/user.class.php');

if (!$session->isLoggedIn()) {
    exit;
}

$db = getDatabaseConnection();

$userId = $session->getId(); 

$images = $_FILES['image'] ?? exitWithError($session, "No image provided");

foreach ($images['tmp_name'] as $index => $tmpName) {
    if ($images['error'][$index] === UPLOAD_ERR_OK) {
        $targetDir = '../profile_pictures/';
        $targetPath = $targetDir . basename($images['name'][$index]);
        if (move_uploaded_file($tmpName, $targetPath)) {
            if (User::changeProfilePic($db, $userId, basename($images['name'][$index]))) {
                $session->addMessage('success', 'Image changed');
            } else {
                $session->addMessage('error', 'Error changing image');
            }
        } else {
            exitWithError($session, "Failed to move uploaded file");
        }
    } else {
        exitWithError($session, "Failed to upload file");
    }
}


header('Location: ' . $_SERVER['HTTP_REFERER']);

function exitWithError($session, string $error): void
{
    $session->addMessage('error', $error);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>