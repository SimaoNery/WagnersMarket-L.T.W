<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/size.class.php');

try {
    $db = getDatabaseConnection();
    $size = $_POST['size'];

    if (Size::deleteSize($db, $size)) $session->addMessage('error', 'Size removed');
    else {
        $session->addMessage('error', 'Not able to remove the size.');
    }


    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

} catch (Exception $e) {
    error_log('Error in action_remove_size.php: ' . $e->getMessage());
    http_response_code(500);
}
