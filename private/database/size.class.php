<?php
declare(strict_types=1);

class Size
{
    public string $size;


    public function __construct(string $size)
    {
        $this->size = $size;
    }


    static function getSizes(PDO $db): array
    {
        $stmt = $db->prepare('SELECT Size FROM SIZE');
        $stmt->execute(array());

        $sizes = array();
        while ($size = $stmt->fetch()) {
            $sizes[] = new SIZE($size['Size']);
        }

        return $sizes;
    }

    static function addSize(PDO $db, string $size): bool
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM SIZE WHERE Size = ?');
        $stmt->execute(array($size));
        $count = $stmt->fetchColumn();
        if ($count === 0) {
            $stmt = $db->prepare('INSERT INTO SIZE (Size) VALUES (?)');
            $stmt->execute(array($size));
            return $stmt->rowCount() == 1;
        }
        return false;
    }

    static function deleteSize(PDO $db, string $size): bool
    {
        $stmt = $db->prepare('DELETE FROM SIZE WHERE Size = ?');
        return $stmt->execute(array($size));
    }
}

?>