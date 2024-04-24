<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/user.class.php');

$db = getDatabaseConnection();

$customer = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);

if ($customer) {
    $session->setId($customer->userId);
    $session->setName($customer->name);
    $session->setToken();
    $session->addMessage('success', 'Login successful!');
} else {
    $session->addMessage('error', 'Wrong credentials!');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>