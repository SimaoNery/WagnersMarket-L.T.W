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


    public function __construct(int $itemId, int $userId, string $title, float $price, string $description, int $condition, int $size, string $brand)
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

      static function getNumItems(PDO $db): int {
          $stmt = $db->prepare('SELECT COUNT(*) FROM ITEM');
          $stmt->execute();
          return (int) $stmt->fetch(PDO::FETCH_COLUMN, 0);
      }
  

      static function getItems(PDO $db, int $count, int $offset) : array {
          $stmt = $db->prepare('SELECT ItemId, UserId, Title, Price, Description, ConditionId, 
            SizeId, Brand FROM ITEM LIMIT ? OFFSET ?');
          $stmt->execute(array($count, $offset));

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

      static function getItemSuggestions(PDO $db, string $text) {
        $searchTerm = "%$text%";
        $stmt = $db->prepare('SELECT ItemId, UserId, Title, Price, Description, ConditionId, 
        SizeId, Brand FROM ITEM WHERE Title LIKE ? OR Description LIKE ? OR Brand LIKE ? LIMIT 5');
        $stmt->execute(array($searchTerm, $searchTerm, $searchTerm));
        
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