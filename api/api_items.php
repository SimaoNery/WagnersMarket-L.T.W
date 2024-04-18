<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/item.class.php');

  $db = getDatabaseConnection();

  $items = Item::getItems($db, $_GET['limit'], $_GET['offset']);

  foreach ($items as &$item) {
    $images = Image::getImages($db, $item->itemId);
    $item->images = $images;    
    }

  echo json_encode($items);
?>