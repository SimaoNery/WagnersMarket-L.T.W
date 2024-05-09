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
}

?>