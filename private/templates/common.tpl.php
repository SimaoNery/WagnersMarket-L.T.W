<?php
declare(strict_types=1);

require_once (__DIR__ . '/../database/user.class.php');
require_once (__DIR__ . '/../../public/utils/session.php');
require_once (__DIR__ . '/../database/category.class.php');

?>

<?php function drawHeader(PDO $db, Session $session)
{ ?>
    <!DOCTYPE html>
    <html lang="en-US">

    <head>
        <title>Wagner's Market</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://kit.fontawesome.com/8c148179b8.js" crossorigin="anonymous"></script>
        <script src="../javascript/imagesLogic.js" defer></script>
        <script src="../javascript/script.js" defer></script>
        <script src="../javascript/suggestion.js"></script>
        <script src="../javascript/wishlistButton.js"></script>
        <script src="../javascript/shoppingBagButton.js"></script>
        <script src="../javascript/trashButton.js"></script>
        <script src="../javascript/checkoutLogic.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap" rel="stylesheet">
    </head>

    <body>
        <header>
            <section class="header-left">
                <a class="logo" href="../pages/index.php">Logo</a>
            </section>
            <section class="header-right">
                <ul>
                    <li>
                        <a href="search.php">Products</a>
                        <ul class="dropdown">
                            <?php $categories = Category::getCategories($db);
                            foreach ($categories as $category) { ?>
                                <li><a href="search.php?category=<?= urlencode($category->categoryName) ?>"><?= $category->categoryName ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li><a href="#" onclick="navigateIfLoggedIn(<?= $session->isLoggedIn() ? 'true' : 'false' ?>)">Sell</a></li>
                    <li>
                        <a href="../pages/profile.php?id=<?= $session->getId() ?>"
                        onclick="navigateIfLoggedIn(<?= $session->isLoggedIn() ? 'true' : 'false' ?>)">Profile</a>
                        <?php
                        if ($session->isLoggedIn())
                            drawProfileForm($db, $session);
                        else
                            drawLoginAndSignUpForm('loginAndSignup', 'chk');
                        ?>
                    </li>
                    <li>
                        <a href="../pages/messages.php?id=<?= $session->getId() ?>"
                            onclick="navigateIfLoggedIn(<?= $session->isLoggedIn() ? 'true' : 'false' ?>)">Messages</a>
                    </li>


                    <li>
                        <a href="../pages/wishlist.php?id=<?= $session->getId() ?>"
                            onclick="navigateIfLoggedIn(<?= $session->isLoggedIn() ? 'true' : 'false' ?>)">
                            <i class="fas fa-heart"></i>
                        </a>
                    </li>
                    <li><a href="../pages/shopping-bag.php?id=<?= $session->getId() ?>"
                            onclick="navigateIfLoggedIn(<?= $session->isLoggedIn() ? 'true' : 'false' ?>)"><i
                                class="fas fa-shopping-bag"></i></a></li>

                </ul>
            </section>
            <?php drawLoginPopUp() ?>
        </header>

    <?php } ?>

    <?php function drawLoginAndSignUpForm(string $class, string $check)
    { ?>
        <section class="loginAndSignup" id="<?= $class ?>">
            <input type="checkbox" id="<?= $check ?>" aria-hidden="true">
            <section class="login">
                <form action="../actions/action_login.php" method="post">
                    <label id="check" for="<?= $check ?>" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button type="submit">Login</button>
                </form>
            </section>

            <section class="signup">
                <form action="../actions/action_signup.php" method="post">
                    <label id="check" for="<?= $check ?>" aria-hidden="true">Sign Up</label>
                    <input type="text" name="name" placeholder="Name" required="">
                    <input type="text" name="username" placeholder="User name" required="">
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button>Sign Up</button>
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
                <h4><?= $session->getName() ?></h4>
            </section>
            <nav class="signup">
                <a href="../pages/your_adds.php?id=<?= $session->getId() ?>">Your Adds</a>
                <a href="../pages/wishlist.php?id=<?= $session->getId() ?>">Wishlist</a>
                <a href="../pages/messages.php?id=<?= $session->getId() ?>">Messages</a>
                <a href="../pages/profile.php?id=<?= $session->getId() ?>">Personal Information</a>
                <a>Reviews</a>
            </nav>
            <form action="../actions/action_logout.php" method="post">
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
        <script src="../../public/javascript/searchUsers.js"></script>
    </body>

    </html>
<?php } ?>

<?php function drawSearchBar(string $id, string $placeholder)
{?>
    <section id="search-bar" class="search-bar">
        <input id="<?= $id ?>" type="text" placeholder="<?= $placeholder ?>">
        <button><i class="fa fa-search"></i></button>
    </section>
<?php } ?>
<?php function drawTitle(string $title): void
{ ?>
    <section id="title">
        <h2>
            <?= $title ?>
        </h2>
        <hr class="line-yellow">
    </section>
<?php } ?>


<?php function drawLoginPopUp()
{ ?>
    <section id="popup-wrapper" class="popup-wrapper">
        <section id="popup" class="popup">
            <section class="popup-content">
                <span class="close" onclick="closeLoginPopUp()">&times;</span>
                <p class="message">You have to login to access this feature</p>
                <?php drawLoginAndSignUpForm('popup-form', 'popup-chk') ?>
            </section>
        </section>
    </section>
<?php } ?>
