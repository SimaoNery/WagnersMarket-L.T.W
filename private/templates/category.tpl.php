<?php declare(strict_types=1); require_once(__DIR__ . '/../database/item_category.class.php' ); require_once(__DIR__
    . '/../../public/utils/session.php' ); ?>
    <?php function drawCategories(array $categories, bool $admin)
    { ?>
        <ul class="category-list">
            <?php foreach ($categories as $category) { ?>
                <li class="category-item">
                    <a href="search.php?category=<?= $category->categoryName ?>">
                        <img src="<?= $category->categoryImage ?>" alt="<?= $category->categoryName ?>">
                        <span><?= $category->categoryName ?></span>
                    </a>
                    <?php if ($admin) { ?>
                        <form class="remove-category" action="../actions/action_remove_category.php" method="post">
                            <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                            <input class="category-name" type="hidden" name="category" value="<?= $category->categoryName ?>">
                            <input class="button" type="submit" value="Remove Category">
                        </form>
                        <button id="change-category-image-popup-<?= $category->categoryName ?>"
                            data-category-id="<?= $category->categoryName ?>" type="button">Change the image</button>
                        <section class="change-category-img-popup" id="change-category-img-popup-<?= $category->categoryName ?>">
                            <form class="change-image-category"
                                action="../actions/action_change_image_category.php" method="post" enctype="multipart/form-data">
                                <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                                <input class="change-image-name" type="hidden" name="category"
                                    value="<?= $category->categoryName ?>">
                                <label>Upload an image<input type="file" name="image" accept="image/png,image/jpeg"
                                        required></label>
                                <input class="button" type="submit" value="Change the category's image">
                            </form>
                        </section>
                    <?php } ?>
                </li>
            <?php }
            if ($admin) { ?>
                <li class="category-item">
                    <a class="add-category-button">
                        <img src="../category_images/add_category.png">
                        <span>Add category</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <?php if ($admin) { ?>
            <section id="add-category-popup">
                <form class="add-new-category" action="../actions/action_add_category.php" method="post"
                    enctype="multipart/form-data">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <label>New category's name<input id="category-name" name="category" type="text" placeholder="e.g. Tops"
                            required></label>
                    <label>Upload an image<input type="file" name="image" accept="image/png,image/jpeg" required></label>
                    <button id="close-add-category-popup">Close</button>
                    <input class="button" type="submit" value="Publish new category">
                </form>
            </section>
        <?php }
    } ?>