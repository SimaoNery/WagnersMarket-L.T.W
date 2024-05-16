<?php
    declare(strict_types=1);
    require_once(__DIR__ . '/../database/item_category.class.php');
    require_once(__DIR__ . '/../../public/utils/session.php');
?>
<?php function drawCategories(array $categories, bool $admin) { ?>
    <ul class="category-list">
        <?php foreach($categories as $category) { ?>
            <li class="category-item">
                <a href="../../public/pages/search.php?category=<?=$category->categoryName?>">
                    <img src="<?=$category->categoryImage?>" alt="<?=$category->categoryName?>">
                    <span><?=$category->categoryName?></span>
                </a>
                <?php if($admin) { ?>
                    <form action="../actions/action_remove_category.php" method="post">
                        <input type="hidden" name="category" value="<?=$category->categoryName?>">
                        <input type="submit" value="Remove Category">
                    </form>
                    <button type="button" value="Change the image">
                    <form action="../actions/action_change_image_category.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="category" value="<?= $category->categoryName?>">
                        <label>Upload an image<input type="file" name="image" accept="image/png,image/jpeg" required></label>
                        <input type="submit" value="Change the category's image">
                    </form>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
    <?php if($admin) { ?>
        <button type="button" value="Add a new category">
        <form id="add-new-category" action="../actions/action_add_category.php" method="post" enctype="multipart/form-data">
            <label>New category's name<input id="category-name" name="category" type="text" placeholder="e.g. Tops" required></label>
            <label>Upload an image<input type="file" name="image" accept="image/png,image/jpeg" required></label>
            <input type="submit" value="Publish new category">
        </form>
        <?php }
} ?>

