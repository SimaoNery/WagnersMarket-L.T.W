<?php 
  declare(strict_types = 1);

require_once(__DIR__ . '/../database/item.class.php');
require_once(__DIR__ . '/../database/image.class.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/condition.class.php');
require_once(__DIR__ . '/../database/category.class.php');
require_once(__DIR__ . '/../database/wishlist.class.php');
require_once(__DIR__ . '/../database/cart.class.php');
?>



<?php function drawItems(PDO $db, array $items, Session $session): void
{ ?>
        <ul class="draw-items" id="draw-items">
            <?php foreach($items as $item) { ?>
                <li class="item-card">
                    <a href="../pages/item.php?id=<?=$item->itemId?>">
                        <img src="<?= $item->imagePath?>">
                    </a>

                    <?php if(!$session->isLoggedIn()) { ?>
                        <button id="not-logged-in" type="button" class="wishlist-button" disabled>
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    <?php } elseif (Wishlist::isInWishlist($db, $session->getId(), $item->itemId)) { ?>
                        <button id="<?= $item->itemId ?>" type="button" class="wishlist-button">
                            <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    <?php } else { ?>
                        <button id="<?= $item->itemId ?>" type="button" class="wishlist-button">
                            <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    <?php } ?>

                    <a href="../pages/item.php?id=<?=$item->itemId?>">
                        <h4><?=$item->title?></h4>
                        <p><?=number_format($item->price, 2)?>€</p>
                    </a>
                </li>
            <?php } ?>
        </ul>
<?php }?>

<?php function drawPagination(int $pages, string $id) { ?>
    <?php if ($pages > 1) { ?>
    <section class="pagination-container">
        <section class="pagination" id="<?= $id ?>">
            <?php for ($i = 1; $i <= min(3, $pages); $i++) { ?>
                <button id="pagination-button" class="pagination-button"><?= $i ?></button>
            <?php } ?>
            <?php if ($pages > 4) { ?>
                <button id="next-button" class="pagination-button">&#8594;</button>
            <?php } ?>
        </section>

        <select id="items-per-page">
            <option value="8">8 per page</option>
            <option value="16">16 per page</option>
            <option value="32">32 per page</option>
        </select>
    </section>
    <?php } ?>
<?php } ?>

<?php function drawItem(PDO $db, Item $item, array $images, Session $session, User $user, int $myId, bool $isAdmin) { ?>
    <?php $editItem = ($myId === $user->userId) ?>
    <section id="<?= $item->itemId ?>" class="item-page">
        <section class="item-images">
            <section class="side-images-container">
                <?php foreach($images as $image) { ?>
                    <img src="/<?= $image->path ?>" class="side-image">
                <?php } ?>
            </section>

            <section class="main-image">
                <img src="/<?= $item->imagePath ?>" id="main-image">
            </section>
            <?php if ($editItem) { ?>
                <button type="button" class="change-images">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">Change Images
                    <i class="fas fa-pencil-alt"></i>
                </button>
            <?php } ?>
        </section>

        <article class="item-info">
            <h1 id="title-name"><?=$item->title?></h1>
            <?php if ($editItem) { ?>
                <button id="<?= $item->itemId ?>" type="button" class="change-title">
                    <input class="title" type="hidden" value="<?=$item->title?>">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <i class="fas fa-pencil-alt"></i>
                </button>
            <?php } ?>



            <h3><?=number_format($item->price, 2)?>€</h3>

            <?php if(!$session->isLoggedIn()) { ?>
                <button id="not-logged-in" type="button" class="wishlist-button" disabled>
                    <i class="fa-regular fa-heart"></i>
                </button>
            <?php } elseif (Wishlist::isInWishlist($db, $session->getId(), $item->itemId)) { ?>
                <button id="<?= $item->itemId ?>" type="button" class="wishlist-button">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <i class="fa-solid fa-heart"></i>
                </button>
            <?php } else { ?>
                <button id="<?= $item->itemId ?>" type="button" class="wishlist-button">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <i class="fa-regular fa-heart"></i>
                </button>
            <?php } ?>

            <?php if(!$session->isLoggedIn()) { ?>
                <button id="not-logged-in" type="button" class="bag-button">
                    <i class="fa-solid fa-bag-shopping"></i> Add To Bag
                </button>

            <?php } elseif (Cart::isInShoppingBag($db, $session->getId(), $item->itemId)) { ?>
                <button id="<?= $item->itemId ?>" type="button" class="bag-button remove-from-bag">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <i id="bag-icon" class="fa-solid fa-bag-shopping"></i>Remove From Cart
                </button>
            <?php } else { ?>
                <button id="<?= $item->itemId ?>" type="button" class="bag-button add-to-bag">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <i id="bag-icon" class="fa-solid fa-bag-shopping"></i>Add To Cart
                </button>
            <?php } ?>

            <?php if ($isAdmin) { ?>
                <button id="<?= $item->itemId ?>" type="button" class="delete-item">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">Delete Post
                </button>
            <?php } ?>

            <?php if ($editItem && !$isAdmin) { ?>
                <button id="<?= $item->itemId ?>" type="button" class="delete-item">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">Delete Post
                </button>
            <?php } ?>

            <section class="product-details">
                <h3>Product Details</h3>
                <h4>Brand: <span id="brand-name"><?=$item->brand?></span></h4>
                <?php if ($editItem) { ?>
                    <button id="<?= $item->itemId ?>" type="button" class="change-brand">
                        <input class="brand" type="hidden" value="<?=$item->brand?>">
                        <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                <?php } ?>
                <h4>Condition: <span id="condition-value"><?=$item->condition?></span></h4>
            </section>
        </article>

        <section class="item-description">
            <?php drawTitle("Product Description");?>
            <p id="description-name" class="description"><?=$item->description?></p>

            <?php if ($editItem) { ?>
                <button type="button" class="change-description">
                    <input class="title" type="hidden" value="<?=$item->description?>">
                    <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <i class="fas fa-pencil-alt"></i>
                </button>
            <?php } ?>
        </section>


        <section class="item-seller">
            <?php drawTitle("Contact Seller");?>

            <section class="seller-info">
                    <img src= "/<?= $user->profilePic ?>">
                    <h2 class="name"><?=$user->name ?></h2>
                    <a href="../pages/messages.php?otherUserId=<?=$user->userId?>" class="send-message-button">Send Message</a>
            </section>

        </section>

    </section>
<?php } ?>

<?php function drawBag(PDO $db, int $user, array $items) { ?>
    <section class="shopping-bag-page" id="shopping-bag-page">
        <ul class="draw-bag" id="draw-bag">
            <?php foreach($items as $item) { ?>
                <li id="item-<?= $item->itemId ?>" class="bag-card" data-price="<?= $item->price ?>">
                    <a href="../pages/item.php?id=<?=$item->itemId?>">
                        <img src="<?= $item->imagePath?>" class="bag-item-image">
                    </a>

                    <section class="bag-item-buttons">
                        <?php if (Wishlist::isInWishlist($db, $user, $item->itemId)) { ?>
                            <button id="<?= $item->itemId ?>" type="button" class="wishlist-button">
                                <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                        <?php } else { ?>
                            <button id="<?= $item->itemId ?>" type="button" class="wishlist-button">
                                <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        <?php } ?>

                        <button id="<?= $item->itemId ?>" type="button" class="trash-button">
                            <input class="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                            <i id="trashIcon" class="fa-solid fa-trash"></i>
                        </button>
                    </section>

                    <a href="../pages/item.php?id=<?=$item->itemId?>">
                        <h4 class="bag-item-title"><?=$item->title?></h4>
                        <p class="bag-item-price"><?=number_format($item->price, 2)?>€</p>
                        <p class="bag-item-brand">Brand: <span id="brandName"><?=$item->brand?></span></p>
                        <p class="bag-item-condition">Condition: <span id="conditionValue"><?=$item->condition?></span></p>
                    </a>
                </li>
            <?php } ?>
        </ul>
<?php } ?>

<?php function drawItemFilter(PDO $db, float $maxPrice, ?string $selectedCategory = null) { ?>
    <?php
        $categories = Category::getCategories($db);
        $conditions = Condition::getConditions($db);
    ?>
    <form id="filters">
        <fieldset id="price">
            <legend>Price Range</legend>
            <section id ="number-input">
                <label>Min: <input type="number" id="min-input" value = "0" min="0" max="<?= intval(ceil($maxPrice))?>"></label>
                <label>Max: <input type="number" id="max-input" value = "<?=intval(ceil($maxPrice))?>" min="0" max="<?=intval(ceil($maxPrice))?>"></label>
            </section>
            <section id="price-range">
                <section id="slider">
                    <section id="progress"></section>
                </section>

                <section id="range-input">
                    <input type="range" id="min-range" min="0" max="<?=intval(ceil($maxPrice))?>" value="0" step="1">
                    <input type="range" id="max-range" min="0" max="<?=intval(ceil($maxPrice))?>" value="<?=intval(ceil($maxPrice))?>" step="1">
                </section>
            </section>
        </fieldset>
        <fieldset id="category">
            <legend>Category</legend>
            <?php foreach($categories as $category) { ?>
                <?php if ($selectedCategory != null) {
                    if ($selectedCategory === $category->categoryName) { ?>
                       <label><?= $category->categoryName ?><input type="checkbox" id="<?= $category->categoryName ?>" checked></label>
                <?php } else { ?>
                <label><?= $category->categoryName ?><input type="checkbox" id="<?= $category->categoryName ?>"></label>
                <?php } } else { ?>
                    <label><?= $category->categoryName ?><input type="checkbox" id="<?= $category->categoryName ?>"></label>
                    <?php } } ?>
        </fieldset>
        <fieldset id="condition">
            <legend>Condition</legend>
            <?php foreach($conditions as $condition) { ?>
                <label><?= $condition->condition ?><input type="checkbox" id="<?= $condition->condition ?>"></label>
            <?php } ?>
        </fieldset>
    </form>
<?php } ?>

<?php function drawItemSorter() { ?>
    <label id="order"> Order By:
        <select id="order-selected">
            <option value="popular" selected>Most Popular</option>
            <option value="asc">Price: Ascending</option>
            <option value="desc">Price: Descending</option>
        </select>
    </label>
<?php } ?>
