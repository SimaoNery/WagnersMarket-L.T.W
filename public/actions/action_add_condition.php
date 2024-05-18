<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/condition.class.php');


$db = getDatabaseConnection();
$condition = $_POST['condition'];

$response = [];

if (Condition::addCondition($db, $condition)) {
    $response = ['success' => 'The condition was successfully added.'];
}
else {
    $response = ['error' => 'An error occurred! The provided condition already exists.'];
}

header('Content-Type: application/json');
echo json_encode($response);


