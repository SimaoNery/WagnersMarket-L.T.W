<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
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

            if (isset($_POST['password'])) {
                $password = htmlspecialchars($_POST['password']);
            } else {
                throw new Exception('Couldn\'t get the first field.');
            }

            if (isset($_POST['new-password'])) {
                $newPassword = htmlspecialchars($_POST['new-password']);
            } else {
                throw new Exception('Couldn\'t get the first second field.');
            }
            $userId = $session->getId();
            $customer = User::getUserWithIdAndPassword($db, $userId, $password);

            if ($customer) {
                if (User::changePassword($db, $userId, $newPassword)) {
                    $session->addMessage('success', 'Password changed.');
                }
                else {
                    $session->addMessage('error', 'Error changing password.');
                }
            } else {
                $session->addMessage('error', 'User and password do not match.');
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



