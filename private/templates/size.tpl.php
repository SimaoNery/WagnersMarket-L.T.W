<?php
declare(strict_types=1);
?>
<?php function drawSizes(array $sizes): void
{ ?>
    <ul id="size-list">
        <?php foreach ($sizes as $size) { ?>
            <li class="size-item">
                <span><?= $size->size ?></span>
                <form class="remove-size" action="../actions/action_remove_size.php" method="post">
                    <input type="hidden" name="size" value="<?= $size->size ?>">
                    <input class="button" type="submit" value="Remove Size">
                </form>
            </li>
        <?php } ?>
        <li class="size-item">
            <form id="add-new-size" action="../actions/action_add_size.php" method="post">
                <label id="new-size">New size's name</label>
                <input id="size-name" name="size" type="text" placeholder="e.g. Small" required>
                <input class="button" type="submit" value="Publish new size">
            </form>
        </li>
    </ul>
<?php } ?>