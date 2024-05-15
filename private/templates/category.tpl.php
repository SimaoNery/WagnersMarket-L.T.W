<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/item_category.class.php');
    require_once(__DIR__ . '/../../public/utils/session.php');
?>
<?php function drawCategories(array $categories) { ?>
    <nav class="category-list">
        <?php foreach($categories as $category) { ?>
            <a class = "category-item" href="../../public/pages/search.php?category=<?=$category->categoryName?>">
                <img src="<?=$category->categoryImage?>" alt="<?=$category->categoryName?>">
                <span><?=$category->categoryName?></span>
            </a>
        <?php } ?>
        </nav>
<?php } ?>

