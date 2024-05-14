<?php
declare(strict_types=1);
?>
<?php function drawSizes(array $sizes) : void { ?>
    <ul class="size-list">
        <?php foreach($sizes as $size) { ?>
            <li class="size-item">
                <span><?=$size->size ?></span>
                <button class="deleteSize"></button>
            </li>
        <?php } ?>
    </ul>
<?php } ?>

