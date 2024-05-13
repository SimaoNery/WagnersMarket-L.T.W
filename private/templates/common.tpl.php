<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../../public/utils/session.php');

?>

<?php function drawHeader(PDO $db, Session $session)
{ ?>
    <!DOCTYPE html>
    <html lang="en-US">

    <head>
        <title>Wagner's Market</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../public/css/style.css">
        <script src="https://kit.fontawesome.com/8c148179b8.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap" rel="stylesheet">
    </head>

    <body>
        <header>
            <section class="header-left">
                <a class="logo" href="../../public/pages/index.php">Logo</a>
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
                        <a href="../../public/pages/profile.php?id=<?= $session->getId() ?>">Profile</a>
                        <?php
                        if ($session->isLoggedIn())
                            drawProfileForm($db, $session);
                        else
                            drawLoginAndSignUpForm();
                        ?>
                    </li>
                    <li><a href="../../public/pages/messages.php">Messages</a></li>
                    <li><a href="../../public/pages/wishlist.php?id=<?= $session->getId() ?>"><i class="fas fa-heart"></i></a></li>
                    <li><a href="../../public/pages/shopping-bag.php?id=<?= $session->getId() ?>"><i class="fas fa-shopping-bag"></i></a></li>

                </ul>
            </section>
        </header>

    <?php } ?>

    <?php function drawLoginAndSignUpForm()
    { ?>
        <section class="loginAndSignup" id="loginAndSignup">
            <input type="checkbox" id="chk" aria-hidden="true">
            <section class="signup">
                <form action="../../public/actions/action_signup.php" method="post">
                    <label id="check" for="chk" aria-hidden="true">Sign Up</label>
                    <input type="text" name="name" placeholder="Name" required="">
                    <input type="text" name="username" placeholder="User name" required="">
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button>Sign Up</button>
                </form>
            </section>

            <section class="login">
                <form action="../../public/actions/action_login.php" method="post">
                    <label id="check" for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button type="submit">Login</button>
                </form>
            </section>

        </section>
    <?php } ?>

    <?php
function drawProfileForm(PDO $db, Session $session)
{ ?>
    <section class="profile" id="profile">
        <section id="user_logged">
            <img src="<?= User::getImgPath($db, $session->getId()) ?>" style="width: 50px; height: 50px;">
            <h4><?= $session->getName()?></h4>
        </section>
        <nav class="signup">
            <a>Your Adds</a>
            <a>Messages</a>
            <a>Personal Information</a>
            <a>Reviews</a>
        </nav>
        <form action="../../public/actions/action_logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </section>
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
        <script src="../../public/javascript/pagination.js"></script>
        <script src="../../public/javascript/messages.js"></script>
        <script src="../../public/javascript/imagesLogic.js" defer></script>
        <script src="../../public/javascript/script.js" defer></script>
        <script src="../../public/javascript/suggestion.js"></script>
        <script src="../../public/javascript/wishlistButton.js"></script>
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
<?php function drawTitle(string $title): void
{ ?>
    <section id="title">
        <h2>
            <?=$title?>
        </h2>
        <hr class="line-yellow">
    </section>
<?php }?>

