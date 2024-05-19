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
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap" rel="stylesheet">
    </head>

    <body>
        <header>
            <section class="header-left">
                <a class="logo" href="../pages/index.php">Logo</a>
            </section>
            <nav class="header-right">
                    <section id="header-products">
                        <a  href="search.php">Products</a>
                        <nav class="dropdown">
                            <?php $categories = Category::getCategories($db);
                            foreach ($categories as $category) { ?>
                                <a href="search.php?category=<?= urlencode($category->categoryName) ?>"><?= $category->categoryName ?></a>
                            <?php } ?>
                        </nav>
                    </section>
                    <?php
                    if ($session->isLoggedIn()) { ?>
                        <a href="../pages/publish_add.php">Sell</a>
                        <nav id="header-profile">
                            <a href="../pages/profile.php">Profile</a>
                            <?php drawProfileForm($db, $session); ?>
                        </nav>
                        <a href="../pages/messages.php">Messages</a>
                        <a href="../pages/wishlist.php"><i class="fas fa-heart"></i></a>
                        <a href="../pages/shopping_bag.php"><i class="fas fa-shopping-bag"></i></a>

                    <?php } else { ?>
                        <a class="not-logged-in">Sell</a>
                        <nav id="header-profile">
                            <a class="not-logged-in">Log in</a>
                            <?php drawLoginAndSignUpForm('login-signup', 'chk'); ?>
                        </nav>
                        <a class="not-logged-in">Messages</a>
                        <a class="not-logged-in"><i class="fas fa-heart"></i></a>
                        <a class="not-logged-in"><i class="fas fa-shopping-bag"></i></a>

                    <?php }?>

            </nav>
            <?php drawLoginPopUp() ?>
        </header>
        <?php /*$messages = $session->getMessages();
        if (count($messages) !== 0) { ?>
            <section id="message-occurred">
                <p id="message-text"><?= $messages[0]['text'] ?></p>
            </section>
        <?php $session->clearMessages();
        } */?>

    <?php } ?>

    <?php function drawLoginAndSignUpForm(string $class, string $check)
    { ?>
        <section class="login-signup" id="<?= $class ?>">
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
            <section id="user-logged">
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
            <nav>
                <a href="#">About</a>
                <a href="#">Purpose</a>
                <a href="#">Contact us</a>
            </nav>
            <p>LTW Wagner's Market &copy; 2024</p>
        </footer>
        <script src="../javascript/pagination.js"></script>
        <script src="../javascript/messages.js"></script>
        <script src="../javascript/imagesLogic.js" defer></script>
        <script src="../javascript/script.js" defer></script>
        <script src="../javascript/suggestion.js"></script>
        <script src="../javascript/wishlistButton.js"></script>
        <script src="../javascript/searchUsers.js"></script>
        <script src="../javascript/shoppingBagButton.js"></script>
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


<?php function drawEmpty(string $id, string $text)
{ ?>
    <p id="<?= $id ?>"><?= $text ?></p>
<?php } ?>