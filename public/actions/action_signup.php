<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/user.class.php');

$db = getDatabaseConnection();

$username = $_POST['name'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];


if (User::getUserByUsername($db, $username)) {
    $session->addMessage('error', 'Username already in use');
    return;
}


if (User::getUserByEmail($db, $email)) {
    $session->addMessage('error', 'Email already in use');
    return;
}

if (User::addUser($db, $name, $username, $email, $password)) {
    $session->addMessage('success','Account created');
}
else {
    $session->addMessage('error', 'Error creating account');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>