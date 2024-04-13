<?php
    declare(strict_types=1);

    class Image {
        public string $path;
        public int $itemId;

        public function __construct(string $path, int $itemId)
        {
            $this->path = $path;
            $this->itemId = $itemId;
        }

        static function getImages(PDO $db, int $itemId) : array {
            $stmt = $db->prepare('
                SELECT Path, ItemId
                FROM IMAGE 
                WHERE ItemId = ?
            ');
            $stmt->execute(array($itemId));

            $images = array();

            while ($image = $stmt->fetch()) {
                $images[] = new Image(
                    $image['Path'],
                    $image['ItemId']
                );
            }

            return $images;
        }
    }
?>
