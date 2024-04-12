<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/item_category.class.php');
?>

<?php function drawCategories(array $categories) { ?>
    <header>
        <h2>Categorias</h2>
    </header>
    <section id="categories">
        <?php foreach($categories as $category) { ?>
            <article>
                <a href="../pages/index.php"><?=$category->categoryId?></a>
            </article>
        <?php } ?>
    </section>
<?php }?>
