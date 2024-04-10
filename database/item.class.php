<?php
  declare(strict_types = 1);

  class Item {
    public int $itemId;
    public int $userId;
    public float $price;
    public string $description;
    public int $condition;
    public int $size;
    public string $brand;


    public function __construct(int $itemId, int $userId, float $price, string $description, int $condition, int $size)
    {
      $this->itemId = $itemId;
      $this->userId = $userId;
      $this->price = $price;
      $this->description = $description;
      $this->condition = $condition;
      $this->size = $size;
      $this->brand = $brand;
    }
  }

?>