<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php');
  require_once(__DIR__ . '/../database/image.class.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/condition.class.php');
require_once(__DIR__ . '/../database/category.class.php');
?>

<?php function drawItems(string $header, array $items): void
{ ?>
  <section id="categories">
      <h2>
          <?=$header?>
      </h2>
      <hr class="line-yellow">
  </section>
  <ul class="draw-items" id="draw-items">
    <?php foreach($items as $item) { ?>
      <li class="item-card">
          <a href="../pages/item.php?id=<?=$item->itemId?>">
          <img src="<?= $item->imagePath?>" style="width: 100px; height: 100px;">
          <h4><?=$item->title?></h4>
              <p><?=number_format($item->price, 2)?>€</p>
          </a>
      </li>
    <?php } ?>
  </ul>

<?php }?>

<?php function drawPagination(int $pages) { ?>
    <div class="pagination-container">
        <div class="pagination" id="pagination">
            <?php for ($i = 1; $i <= min($pages, 3); $i++) { ?>
                <button id="pagination-button" class="pagination-button"><?= $i ?></button>
            <?php } ?>
            <?php if ($pages > 4) { ?>
                <button id="pagination-button" class="pagination-button">&#8594;</button>
            <?php } ?>
    </div>

    <select id="itemsPerPage">
        <option value="4">4 per page</option>
        <option value="8">8 per page</option>
        <option value="16">16 per page</option>
    </select>
    </div>
<?php } ?>

<?php function drawItem(Item $item, PDO $db) { ?>
    <section class="row">
        <section id="images" class="col-2">
            <?php
                $images = Image::getImages($db, $item->itemId);
                $mainImage = $images[0];
            ?>

            <div class="sideImagesContainer">
                    <?php foreach($images as $image) { ?>
                        <img src="/<?= $image->path ?>" id="<?= $image->imageId ?>" class="sideImage">
                    <?php } ?>
            </div>

            <div class="main_image">
                <img src="/<?= $mainImage->path ?>" id="mainImage" data-id="<?= $mainImage->imageId ?>">
            </div>
        </section>

        <section id="information" class="col-2">
            <article id="mainInfo">
                <h1><?=$item->title?></h1>
                <ul>
                    <li>
                        <?=number_format($item->price, 2)?>€
                    </li>
                    <li id="wishlist">
                        <button class="add-to-wishlist-button">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </li>
                    <li id="bag">
                        <button class="add-to-bag-button">
                            <i class="fa-solid fa-bag-shopping"></i> Add To Bag
                        </button>
                    </li>
                </ul>
            </article>

            <h3>Product Details</h3>

            <p>Brand: <span id="brandName"><?=$item->brand?></span></p>
            <p>Condition: <span id="conditionValue"><?=$item->condition?></span></p>

        </section>
    </section>

    <section id="description_seller">
        <h2>Product Description</h2>
        <hr class="line-yellow">

        <div class="box_yellow">
            <p class="description"><?=$item->description?></p>
        </div>

        <h2>Contact the seller</h2>
        <hr class="line-yellow">

        <div class="box_yellow">
            <section id="sellerInfo">
                <?php $user = User::getUser($db, $item->userId); ?>
                <div class="profilePic">
                    <a href="../pages/profile.php">
                        <img src= "/<?= $user->profilePic ?>">
                    </a>
                </div>

                <div class="sellerDetails">
                    <a href="../pages/profile.php">
                        <p class="username"><?=$user->username?></p>
                    </a>

                    <a href="../pages/profile.php">
                        <p class="name"><?=$user->name ?></p>
                    </a>
                </div>

                <button class="sendMessageButton">
                    <p>Send Message</p>
                </button>

            </section>
        </div>
    </section>
<?php } ?>




<?php function drawItemFilter(PDO $db, float $maxPrice) { ?>
    <?php
    $categories = Category::getCategories($db);
    $conditions = Condition::getConditions($db);
    ?>
    <form id="filters">
        <fieldset id="price-range">
            <legend>Price Range</legend>
            <label>Min: <input type="number" id="min-input" value = "0" min="0" max="<?= $maxPrice?>"></label>
            <label>Max: <input type="number" id="max-input" value = "<?=$maxPrice?>" min="0" max="<?=$maxPrice?>"></label>
            <input type="range" id="min-range" min="0" max="<?=$maxPrice?>" value="0" step="1">
            <input type="range" id="max-range" min="0" max="<?=$maxPrice?>" value="<?=$maxPrice?>" step="1">
        </fieldset>
        <fieldset id="category">
            <legend>Category</legend>
            <?php foreach($categories as $category) { ?>
                <label><?= $category->categoryName ?></label><input type="checkbox" id="<?= $category->categoryName ?>"></label>
            <?php } ?>
        </fieldset>
        <fieldset id="condition">
            <legend>Condition</legend>
            <?php foreach($conditions as $condition) { ?>
                <label><?= $condition->condition ?></label><input type="checkbox" id="<?= $condition->condition ?>"></label>
            <?php } ?>
        </fieldset>
    </form>
<?php } ?>

<?php function drawItemSorter() { ?>
    <label> Order By:
        <select id="orderSelected">
            <option value="popular" selected>Most Popular</option>
            <option value="asc">Price: Ascending</option>
            <option value="desc">Price: Descending</option>
        </select>
    </label>
<?php } ?>
