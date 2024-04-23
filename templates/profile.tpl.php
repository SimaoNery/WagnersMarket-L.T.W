<?php
declare(strict_types=1);
?>

<?php function  drawProfileBody(string $page, int $userId) { ?>
    <nav id="profile-pages" id="<?= $page ?>>">
        <a href="../pages/your_adds.php?id=<?=$userId?>">Your Adds</a>
        <a href="../pages/wishlist.php?id=<?=$userId?>">Wishlist</a>
        <a href="../pages/messages.php?id=<?=$userId?>">Messages</a>
        <a href="../pages/personal_information.php?id=<?=$userId?>">Personal Information</a>
        <a href="../pages/reviews.php?id=<?=$userId?>">Reviews</a>
    </nav>
<?php }?>

