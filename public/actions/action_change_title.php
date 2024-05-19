<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/access_denied.php');
    exit();
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');

header('Location: ' . $_SERVER['HTTP_REFERER']);
$db = getDatabaseConnection();

try {

    if (isset($_POST['csrf'])) {
        $csrf = $_POST['csrf'];


        if ($csrf === $session->getToken()) {

            if (isset($_POST['itemId'])) {
                $itemId = intval($_POST['itemId']);

            } else {
                $session->addMessage('error', 'No item provided');
                exit();
            }

            if (isset($_POST['title'])) {
                $title = $_POST['title'];

            } else {
                $session->addMessage('error', 'No title provided');
                exit();
            }

            if (Item::getItem($db, $itemId)) {
                if (Item::changeTitle($db, $itemId, $title)) {
                    $session->addMessage('success', 'Title changed successfully.');
                } else {
                    $session->addMessage('error', 'Failed to change brand.');
                }
            } else {
                $session->addMessage('error', 'No item found.');
            }

        } else {
            $session->addMessage('error', 'An error occurred! The tokens do not match.');
        }
    } else {
        $session->addMessage('error', 'An error occurred! Couldn\'t get token.');
    }

} catch (PDOException $e) {
    $db->rollBack();
    $session->addMessage('error', 'A database error occurred. Please try again later.');

} catch (Exception $e) {
    $session->addMessage('error', 'An error occurred. Please try again later.');
}
?>