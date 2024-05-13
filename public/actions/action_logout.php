<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    exit;
}

$session->logout();

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>