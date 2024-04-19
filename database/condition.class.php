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

      static function getCondition(PDO $db, int $id) : Condition {
          $stmt = $db->prepare('SELECT  ConditionId, ConditionVal FROM CONDITION WHERE ConditionId = ?');
          $stmt->execute(array($id));

          $condition = $stmt->fetch();

          return new Condition(
              $condition['ConditionId'],
              $condition['ConditionVal']
          );
      }
  }

?>