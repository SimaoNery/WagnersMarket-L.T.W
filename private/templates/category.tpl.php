<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/item_category.class.php');
    require_once(__DIR__ . '/../../public/utils/session.php');
?>
<?php function drawCategories(array $categories) { ?>

    <section id="title">
        <h2>Categories</h2>
        <hr class="line-yellow"> 

        <ul class="category-list">
            <?php foreach($categories as $category) { ?>
                <li class="category-item">
                    <a href="../../public/pages/search.php?category=<?=$category->categoryName?>">
                        <img src="<?=$category->categoryImage?>" alt="<?=$category->categoryName?>">
                        <span><?=$category->categoryName?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </section>

<?php } ?>

