<?php
declare(strict_types=1);

class Condition
{
    public string $condition;


    public function __construct(string $condition)
    {
        $this->condition = $condition;
    }

    static function getConditions(PDO $db): array
    {
        $stmt = $db->prepare('SELECT Condition FROM CONDITION');
        $stmt->execute(array());

        $conditions = array();
        while ($condition = $stmt->fetch()) {
            $conditions[] = new Condition(
                $condition['Condition']
            );
        }

        return $conditions;
    }

    static function addCondition(PDO $db, string $condition): bool
    {
        $stmt = $db->prepare('INSERT INTO CONDITION (Condition) VALUES (?)');
        $stmt->execute(array($condition));
        return $stmt->rowCount() == 1;
    }

    static function deleteCategories(PDO $db, string $condition): bool
    {
        $stmt = $db->prepare('DELETE FROM CONDITION WHERE Condition = ?');
        return $stmt->execute(array($condition));
    }
}

?>