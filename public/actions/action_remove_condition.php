<?php
declare(strict_types=1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/condition.class.php');


$db = getDatabaseConnection();
$condition = $_POST['condition'];

$response = [];

if(Condition::deleteCondition($db, $condition)) {
    $response = ['success' => 'The condition was successfully removed.'];
} else {
    $response = ['error' => 'An error occurred! The condition could not be removed.'];
}

header('Content-Type: application/json');
echo (json_encode($response));

?>
