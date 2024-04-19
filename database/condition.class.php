<?php
  declare(strict_types = 1);

  class Condition {
    public string $condition;


    public function __construct(string $condition)
    {
      $this->condition = $condition;
    }
  }
?>