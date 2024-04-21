<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/item_category.class.php');
?>
<?php function drawCategories(array $categories) { ?>

    <section id="categories">
        <h2>Categories</h2>
        <hr class="line-yellow"> 

        <ul class="category-list">
            <?php foreach($categories as $category) { ?>
                <li class="category-item">
                    <a href="../pages/search.php?category=<?=$category->categoryName?>">
                        <img src="<?=$category->categoryImage?>" alt="<?=$category->categoryName?>">
                        <span><?=$category->categoryName?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </section>

<?php } ?>

