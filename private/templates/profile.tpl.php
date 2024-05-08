<?php
declare(strict_types=1);
?>

<?php function drawProfileBody(string $page, int $userId) { ?>
    <nav class="profile-pages" id="<?= $page ?>>">
        <a href="../../public/pages/your_adds.php?id=<?=$userId?>" <?= $page === "your_adds" ? 'class="highlighted"' : '' ?>>Your Adds</a>
        <a href="../../public/pages/wishlist.php?id=<?=$userId?>" <?= $page === "wishlist" ? 'class="highlighted"' : '' ?>>Wishlist</a>
        <a href="../../public/pages/messages.php?id=<?=$userId?>" <?= $page === "messages" ? 'class="highlighted"' : '' ?>>Messages</a>
        <a href="../../public/pages/personal_information.php?id=<?=$userId?>" <?= $page === "personal_information" ? 'class="highlighted"' : '' ?>>Personal Information</a>
        <a href="../../public/pages/reviews.php?id=<?=$userId?>" <?= $page === "reviews" ? 'class="highlighted"' : '' ?>>Reviews</a>
    </nav>
<?php }?>

