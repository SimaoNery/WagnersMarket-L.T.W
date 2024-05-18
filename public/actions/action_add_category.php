<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/category.class.php');


$db = getDatabaseConnection();
$category = $_POST['category'] ?? '';
$image = $_FILES['image'];

$fileName = $image['tmp_name'];
$targetDir = "../images/";
$targetPath = $targetDir . basename($image['name']);

$response = [];

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

header('Content-Type: application/json');
echo json_encode($response);


