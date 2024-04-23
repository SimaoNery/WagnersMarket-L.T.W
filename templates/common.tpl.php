<?php
declare(strict_types=1);
?>

<?php function drawHeader(Session $session)
{ ?>
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
                    <li>
                        <a href="../pages/profile.php?id=<?= $user ?>">Profile</a>
                        <?php
                        if ($session->isLoggedIn())
                            drawProfileForm($session);
                        else
                            drawLoginAndSignUpForm();
                        ?>
                    </li>
                    <li><a href="../pages/messages.php?id=<?= $user ?>">Messages</a></li>
                    <li><a href="../pages/wishlist.php?id=<?= $user ?>"><i class="fas fa-heart"></i></a></li>
                    <li><a href="../pages/shopping-bag.php?id=<?= $user ?>"><i class="fas fa-shopping-bag"></i></a></li>

                </ul>
            </section>
        </header>

    <?php } ?>

    <?php function drawLoginAndSignUpForm()
    { ?>
        <section class="loginAndSignup" id="loginAndSignup">
            <input type="checkbox" id="chk" aria-hidden="true">
            <section class="signup">
                <form action="../actions/action_signup.php" method="post">
                    <label id="check" for="chk" aria-hidden="true">Sign Up</label>
                    <input type="text" name="name" placeholder="Name" required="">
                    <input type="text" name="username" placeholder="User name" required="">
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button>Sign Up</button>
                </form>
            </section>

            <section class="login">
                <form action="../actions/action_login.php" method="post">
                    <label id="check" for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button type="submit">Login</button>
                </form>
            </section>

        </section>
    <?php } ?>

    <?php function drawProfileForm(Session $session)
    { ?>
    
    <?php } ?>

    <?php function drawFooter()
    { ?>

        <footer>
            <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Purpose</a></li>
                <li><a href="#">Contact us</a></li>
            </ul>
            <p>LTW Wagner's Market &copy; 2024</p>
        </footer>
        <script src="../javascript/pagination.js"></script>
        <script src="../javascript/imagesLogic.js" defer></script>
        <script src="../javascript/script.js" defer></script>
        <script src="../javascript/suggestion.js"></script>
    </body>

    </html>
<?php } ?>

<?php function drawSearchBar(string $id)
{ ?>
    <section id="<?= $id ?>" class="search-bar">
        <input id="searchitem" type="text" placeholder="What are you looking for?">
        <button><i class="fa fa-search"></i></button>
    </section>
<?php } ?>