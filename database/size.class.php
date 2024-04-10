<?php
  declare(strict_types = 1);

  class Condition {
    public int $sizeId;
    public string $sizeVal;


    public function __construct(int $sizeId, string $sizeVal)
    {
      $this->sizeId = $sizeId;
      $this->sizeVal = $sizeVal;
    }
  }

?>