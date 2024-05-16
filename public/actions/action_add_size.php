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

    if (Size::addSize($db, $size)) $session->addMessage('error', 'Size added');
    else {
        $session->addMessage('error', 'Not able to add size.');
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

} catch (Exception $e) {
    error_log('Error in action_add_size.php: ' . $e->getMessage());
    http_response_code(500);
}
