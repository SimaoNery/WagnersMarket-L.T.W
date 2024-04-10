<?php
  declare(strict_types = 1);

  class Condition {
    public int $conditionId;
    public string $conditionVal;


    public function __construct(int $conditionId, string $conditionVal)
    {
      $this->conditionId = $conditionId;
      $this->conditionVal = $conditionVal;
    }
  }

?>