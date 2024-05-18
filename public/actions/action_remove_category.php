<?php
declare(strict_types=1);


require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/category.class.php');


$db = getDatabaseConnection();
$category = $_POST['category'];

$response = [];

if(Category::deleteCategory($db, $category)) {
    $response = ['success' => 'The category was successfully removed.'];
} else {
    $response = ['error' => 'An error occurred! The category could not be removed.'];
}

header('Content-Type: application/json');
echo (json_encode($response));

?>
