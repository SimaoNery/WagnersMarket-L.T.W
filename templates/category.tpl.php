<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/item_category.class.php');
?>

<?php function drawCategories(array $categories) { ?>
    <header>
        <h2>Categories</h2>
    </header>
    <section id="categories">
        <?php foreach($categories as $category) { ?>
            <article>
                <a href="../pages/search.php?id=<?=$category->id?>"><?=$category->categoryName?></a>
                <img src= "<?=$category->categoryImage?>" <!-- To adjust image size: style="width: 100px; height: 100px;"-->
            </article>
        <?php } ?>
    </section>
<?php }?>
