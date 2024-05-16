<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/category.class.php');

try {
    $db = getDatabaseConnection();
    $category = $_POST['category'];

    if (Category::deleteCategory($db, $category)) $session->addMessage('error', 'Category removed');
    else {
        $session->addMessage('error', 'Not able to remove the category.');
    }


    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

} catch (Exception $e) {
    error_log('Error in action_remove_category.php: ' . $e->getMessage());
    http_response_code(500);
}
