<?php
    declare(strict_types=1);

    class Img {
        public string $path;
        public int $itemId;

        public function __construct(string $path, int $itemId)
        {
            $this->path = $path;
            $this->itemId = $itemId;
        }
    }
?>
