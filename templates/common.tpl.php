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
            <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap" rel="stylesheet">
        </head>
        <body>
            <header>
                <section class="header-left">
                    <a class="logo" href="index.php">Logo</a>
                </section>
                <section class="header-right">
                    <ul>
                        <li>
                            <a href="#">Products</a>
                            <ul class="dropdown">
                                <li><a href="#">Random 1</a></li>
                                <li><a href="#">Random 2</a></li>
                                <li><a href="#">Random 3</a></li>
                            </ul>
                        </li>

                        <li><a href="#">Sell</a></li>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="messages.php">Messages</a></li>
                        <li><a href="wishlist.php"><i class="fas fa-heart"></i></a></li>
                        <li><a href="shopping-bag.php"><i class="fas fa-shopping-bag"></i></a></li>
                    
                        </ul>
</section>
            </header>
            <div class="scroll-watcher"></div>

<?php } ?>

<?php function drawFooter() { ?>

            <footer>
                <ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Purpose</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
                <p>LTW Wagner's Market &copy; 2024</p>
            </footer>
            <script src="../javascript/pagination.js"></script>
        </body>
    </html>
<?php } ?>

