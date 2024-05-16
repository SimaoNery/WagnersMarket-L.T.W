<?php
declare(strict_types=1);
?>
<?php function drawConditions(array $conditions) : void { ?>
    <ul id="condition-list">
        <?php foreach($conditions as $condition) { ?>
            <li class="size-item">
                <span><?=$condition->condition ?></span>
                <form action="../actions/action_remove_condition.php" method="post">
                    <input type="hidden" name="condition" value="<?= $condition->condition ?>">
                    <input type="submit" value="Remove condition">
                </form>
            </li>
        <?php } ?>
    </ul>
    <button type="button" value="Add new condition">
    <form id="add-new-condition" action="../actions/action_add_condition.php" method="post">
        <label> New condition's name <input id="condition-name" name="condition" type="text" placeholder="e.g. Tops" ></label>
        <input type="submit" value="Publish new condition">
    </form>
<?php } ?>

