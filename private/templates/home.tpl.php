<?php
declare(strict_types=1);

require_once __DIR__ . '/common.tpl.php';
?>


<?php function drawHomeBody() { ?>
    <section class="row">
        <section class="col-2" id="left">
            <h1>
                Wagner's<br>Market
            </h1>
            <p>
                Looking for anything?<br>You've just come to the right place!
            </p>
            <a href="" class="btn">Explore Now &#8594;</a>
        </section>
        <section class="col-2" id="right">
                <?php drawSearchBar("search-bar", "What are you looking for?") ?>
                <ul class="suggestions" id="suggestions"></ul>
        </section>
    </section>
<?php }?>

