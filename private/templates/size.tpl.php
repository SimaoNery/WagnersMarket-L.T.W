<?php
declare(strict_types=1);
?>
<?php function drawSizes(array $sizes) : void { ?>
    <ul id="size-list">
        <?php foreach($sizes as $size) { ?>
            <li class="size-item">
                <span><?=$size->size ?></span>

                <form action="../actions/action_remove_size.php" method="post">
                    <input type="hidden" name="size" value="<?= $size->size ?>">
                    <input type="submit" value="Remove Size">
                </form>
            </li>
        <?php } ?>
    </ul>
    <button type="button" value="Add new size">
    <form id="add-new-size" action="../actions/action_add_size.php" method="post">
        <label>New size's name<input id="size-name" name="size" type="text" placeholder="e.g. Small" required></label>
        <input type="submit" value="Publish new size">
    </form>
<?php } ?>

