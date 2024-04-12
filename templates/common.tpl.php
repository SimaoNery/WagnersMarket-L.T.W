<?php
    declare(strict_types=1);
?>

<?php function drawHeader() { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Wagner's Market</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="/css/style.css">
            <script src="https://kit.fontawesome.com/8c148179b8.js" crossorigin="anonymous"></script>
        </head>
        <body>
            <header>
                <h1>
                    <a href="index.php">Wagner's Market</a>
                    <!-- Show if logged-in session | Otherwise show LogIn Screen -->
                </h1>
                <h2>
                    <a href="wishlist.php"><i class="fa-solid fa-heart"></i>Wishlist</a>
                    <a href="profile.php"><i class="fa-solid fa-user"></i>Your Profile</a>
                    <a href="messages.php"><i class="fa-solid fa-message"></i>Messages</a>
                </h2>
            </header>

<?php } ?>

<?php function drawFooter() { ?>
            <footer>
                 LTW Wagner's Market &copy; 2024
            </footer>
        </body>
    </html>
<?php } ?>

