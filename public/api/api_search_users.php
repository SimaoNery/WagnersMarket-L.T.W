<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();


require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/user.class.php');

try {
    $db = getDatabaseConnection();
    $response = [];

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    } else {
        throw new Exception('Couldn\'t obtain search.');
    }
    if (isset($_GET['limit'])) {
        $limit = intval($_GET['limit']);
    } else {
        throw new Exception('Couldn\'t obtain limit.');
    }
    if (isset($_GET['offset'])) {
        $offset = intval($_GET['offset']);
    } else {
        throw new Exception('Couldn\'t obtain offset.');
    }

    $users = User::getUserByAnything($db, $search, $limit, $offset);

    header('Content-Type: application/json');
    echo json_encode($users);


} catch (PDOException $e) {
    $response = ['error' => 'A database error occurred. Please try again later.'];

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (Exception $e) {

    $response = ['error' => 'An error occurred. Please try again later.'];

    header('Content-Type: application/json');
    echo json_encode($response);
}





