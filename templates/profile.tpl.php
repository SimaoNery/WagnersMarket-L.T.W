<?php
declare(strict_types=1);
?>

<?php function drawProfileBody(string $page, int $userId) { ?>
    <nav id="profile-pages" id="<?= $page ?>>">
        <a href="../your_adds.php&id=<?=$userId?>">Your Adds</a>
        <a href="../wishlist.php&id=<?=$userId?>">Wishlist</a>
        <a href="../messages.php&id=<?=$userId?>">Messages</a>
        <a href="../personal_information.php&id=<?=$userId?>">Personal Information</a>
        <a href="../reviews.php&id=<?=$userId?>">Reviews</a>
    </nav>
<?php }?>

