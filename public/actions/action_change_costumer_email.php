<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
    handleBadAccess("You don't have permission to access this page!", $session);
    exit();
}


require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/user.class.php');


header('Location: ' . $_SERVER['HTTP_REFERER']);

try {

    $db = getDatabaseConnection();

    if (isset($_POST['csrf'])) {
        $csrf = urldecode($_POST['csrf']);

    if ($csrf === $session->getToken()) {

        if (isset($_POST['email'])) {
            $email = htmlspecialchars($_POST['email']);
        } else {
            throw new Exception('Couldn\'t get the new name.');
        }

        $userId = $session->getId();

        if (User::getUserByEmail($db, $email)) {
            $session->addMessage('error', 'Email already in use');
        } else {
            if (User::changeEmail($db, $userId, $email)) {
                $session->addMessage('success', 'Email changed');
            } else {
                $session->addMessage('error', 'Error changing email');
            }
        }

    } else {
        $session->addMessage('error', 'An error occurred! The tokens do not match.');
    }
} else {
    $session->addMessage('error', 'An error occurred! Couldn\'t get token.');
}

} catch (PDOException $e) {
    $session->addMessage('error', 'A database error occurred. Please try again later.');

} catch (Exception $e) {
    $session->addMessage('error', 'An error occurred. Please try again later.');
}









