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
}

?>