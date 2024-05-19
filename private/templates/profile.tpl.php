<?php
declare(strict_types=1);
?>

<?php function drawProfileBody(string $page, int $userId)
{ ?>
    <nav class="profile-pages" id="<?= $page ?>>">
        <a href="../pages/your_adds.php?id=<?=$userId?>" <?= $page === "your_adds" ? 'class="highlighted"' : '' ?>>Your Adds</a>
        <a href="../pages/wishlist.php?id=<?=$userId?>" <?= $page === "wishlist" ? 'class="highlighted"' : '' ?>>Wishlist</a>
        <a href="../pages/messages.php?id=<?=$userId?>" <?= $page === "messages" ? 'class="highlighted"' : '' ?>>Messages</a>
        <a href="../pages/profile.php?id=<?=$userId?>" <?= $page === "personal_information" ? 'class="highlighted"' : '' ?>>Personal Information</a>
        <a href="../pages/reviews.php?id=<?=$userId?>" <?= $page === "reviews" ? 'class="highlighted"' : '' ?>>Reviews</a>
    </nav>
<?php } ?>

<?php function drawPersonalInformationBody(PDO $db, User $user)
{ ?>
    <section class="personal-information-body">
        <section class="left-side">
            <img src="<?= $user->profilePic ?>">
            <button id="edit-image-button"><i class="fas fa-pencil-alt"></i></button>
        </section>

        <section class="right-side">
            <section class="profile-info" id="name-info">
                <label>Name</label>
                <span id="name-span"><?= $user->name ?></span>
                <button id="edit-name-button"><i class="fas fa-pencil-alt"></i></button>
            </section>
            <section class="profile-info" id="email-info">
                <label>Email</label>
                <span id="email-span"><?= $user->email ?></span>
                <button id="edit-email-button"><i class="fas fa-pencil-alt"></i></button>
            </section>

            <form action="../actions/action_change_password.php" method="post">
                <span>Change Password</span>
                <section id="input-fields">
                    <input type="password" name="password" placeholder="Old password" required="" id="old-psw">
                    <input type="password" name="new-password" placeholder="New password" required="" id="new-psw">
                    <button>Change</button>
                </section>
            </form>

        </section>

    </section>
<?php } ?>