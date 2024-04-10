<?php
    declare(strict_types=1);

    class ItemCategory {
        public int $categoryId;
        public int $itemId;

        public function __construct(int $categoryId, int $itemId)
        {
            $this->categoryId = $categoryId;
            $this->itemId = $itemId;
        }
    }
?>
