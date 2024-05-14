<?php
declare(strict_types=1);
require_once __DIR__ . '/common.tpl.php';
require_once __DIR__ . '/category.tpl.php';
require_once __DIR__ . '/size.tpl.php';
//require_once __DIR__ . '/condition.tpl.php';
?>
<?php function drawAdminBoard(array $categories, array $conditions, array $sizes) { ?>

    <section id="adminBoard">
        <section id="editUsers">
            <?php drawTitle("Manage Users");
                drawSearchBar("searchUsers", "Search for a user with his ID, username or email account");?>
            <section id="users"></section>
        </section>
        <section id="editCategories">
            <?php drawTitle("Manage Categories");
            drawCategories($categories);?>
        </section>
        <section id="editConditions">
            <?php drawTitle("Manage Item Conditions");
            //drawConditions($conditions);?>
        </section>
        <section id="editSizes">
            <?php drawTitle("Manage Item Sizes");
            drawSizes($sizes);?>
        </section>
    </section>

<?php } ?>

