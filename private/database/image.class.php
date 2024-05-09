<?php
declare(strict_types=1);

class Image
{
    public int $imageId;
    public string $path;
    public int $itemId;

    public function __construct(int $imageId, string $path, int $itemId)
    {
        $this->imageId = $imageId;
        $this->path = $path;
        $this->itemId = $itemId;
    }

    static function getImages(PDO $db, int $itemId): array
    {
        $stmt = $db->prepare('
                SELECT ImageId, Path, ItemId
                FROM IMAGE 
                WHERE ItemId = ?
            ');
        $stmt->execute(array($itemId));

        $images = array();

        while ($image = $stmt->fetch()) {
            $images[] = new Image(
                $image['ImageId'],
                $image['Path'],
                $image['ItemId']
            );
        }

        return $images;
    }

    static function addImage(PDO $db, int $itemId, string $imagePath): bool
    {
        $stmt = $db->prepare('INSERT INTO IMAGE (Path, ItemId) VALUES (?, ?)');

        $stmt->execute(array($imagePath, $itemId));

        return $stmt->rowCount() == 1;
    }
}

?>
