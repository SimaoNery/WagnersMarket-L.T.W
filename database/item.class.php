<?php
  declare(strict_types = 1);

  class Item {
    public int $itemId;
    public int $userId;
    public string $title;
    public float $price;
    public string $description;
    public int $condition;
    public int $size;
    public string $brand;


    public function __construct(int $itemId, string $title, int $userId, float $price, string $description, int $condition, int $size, string $brand)
    {
      $this->itemId = $itemId;
      $this->userId = $userId;
      $this->title = $title;
      $this->price = $price;
      $this->description = $description;
      $this->condition = $condition;
      $this->size = $size;
      $this->brand = $brand;
    }


      static function getItems(PDO $db, int $count) : array {
          $stmt = $db->prepare('SELECT ItemId, UserId, Title, Price, Description, ConditionId, 
            SizeId, Brand FROM ITEM LIMIT ?');
          $stmt->execute(array($count));

          $items = array();
          while ($item = $stmt->fetch()) {
              $items[] = new Item(
                  $item['ItemId'],
                  $item['UserId'],
                  $item['Title'],
                  $item['Price'],
                  $item['Description'],
                  $item['ConditionId'],
                  $item['SizeId'],
                  $item['Brand']
              );
          }

          return $items;
      }
  }

?>