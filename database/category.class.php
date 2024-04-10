<?php
    declare(strict_types=1);

    class Category {
        public string $categoryName;

        public function __construct(string $categoryName)
        {
            $this->categoryName = $categoryName;
        }
    }
?>
