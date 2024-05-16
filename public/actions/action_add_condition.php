<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/condition.class.php');

try {
    $db = getDatabaseConnection();
    $condition = $_POST['condition'];

    if (Condition::addCondition($db, $condition)) $session->addMessage('error', 'Condition added');
    else {
        $session->addMessage('error', 'Not able to add the condition.');
    }


    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

} catch (Exception $e) {
    error_log('Error in action_add_condition.php: ' . $e->getMessage());
    http_response_code(500);
}
