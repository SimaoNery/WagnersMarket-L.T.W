<?php
declare(strict_types=1);
?>
<?php function drawConditions(array $conditions) : void { ?>
    <ul id="condition-list">
        <?php foreach($conditions as $condition) { ?>
            <li class="size-item">
                <span><?=$condition->condition ?></span>
                <form class="remove-condition" action="../actions/action_remove_condition.php" method="post">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <input class="condition-name" type="hidden" name="condition" value="<?= $condition->condition ?>">
                    <input class="button" type="submit" value="Remove condition">
                </form>
            </li>
        <?php } ?>
        <li class="size-item">
            <form id="add-new-condition" action="../actions/action_add_condition.php" method="post">
                <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                <label id="new-condition">New condition's name</label>
                <input id="condition-name" name="condition" type="text" placeholder="e.g. Fair" required>
                <input class="button" type="submit" value="Publish new condition">
            </form>
        </li>
    </ul>
<?php } ?>

