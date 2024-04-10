<?php
    declare(strict_types = 1);

    class Cart {
        public int $userId;
        public int $itemId;

        public function __construct(int $userId, int $itemId)
        {
            $this->userId = $userId;
            $this->itemId = $itemId;
        }

    }
?>