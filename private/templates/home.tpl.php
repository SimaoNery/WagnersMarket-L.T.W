<?php
declare(strict_types=1);

require_once __DIR__ . '/common.tpl.php';
?>


<?php function drawHomeBody() { ?>
    <section class="home-body">
        <section class="home-body-left">
            <h1>
                Wagner's<br>Market
            </h1>
            <p>
                Looking for anything?<br>You've just come to the right place!
            </p>
            <a href="search.php" class="button">Explore Now &#8594;</a>
        </section>
        <section class="home-body-right">
                <?php drawSearchBar("search-item", "What are you looking for?") ?>
                <ul class="suggestions" id="suggestions"></ul>
        </section>
    </section>
<?php }?>

