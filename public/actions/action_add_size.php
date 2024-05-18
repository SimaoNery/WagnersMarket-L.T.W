<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/size.class.php');


$db = getDatabaseConnection();
$size = $_POST['size'];

$response = [];

if (Size::addSize($db, $size)) {
    $response = ['success' => 'The package size was successfully added.'];
}
else {
    $response = ['error' => 'An error occurred! The provided package size already exists.'];
}

header('Content-Type: application/json');
echo json_encode($response);


