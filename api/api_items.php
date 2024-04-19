<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/item.class.php');

$db = getDatabaseConnection();

$search = $_GET['search'];
$categories = empty($_GET['category']) ? [] : explode(';', $_GET['category']);
$conditions = empty($_GET['condition']) ? [] : explode(';', $_GET['condition']);
$min = $_GET['min'];
$max = $_GET['max'];
$order = $_GET['order'];


$items = Item::searchItems($db, $search, $categories, $conditions, $min, $max, $order,  8);
echo json_encode($items);
?>