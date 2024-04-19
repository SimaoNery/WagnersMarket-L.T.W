<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php');
  require_once(__DIR__ . '/../database/image.class.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/condition.class.php');
?>

<?php function drawItems(array $items, PDO $db, int $pages, int $limit) { ?>
  <section id="categories">
      <h2>
          Most Popular
      </h2>
      <hr class="line-yellow">
  </section>
  <ul class="most-popular" id="most-popular">
    <?php foreach($items as $item) { ?>
      <li class="item-card">
          <a href="../pages/item.php?id=<?=$item->itemId?>">
          <img src="<?= (Image::getImages($db, $item->itemId)[0])->path ?>" style="width: 100px; height: 100px;">
          <h4><?=$item->title?></h4>
              <p><?=number_format($item->price, 2)?>€</p>
          </a>
      </li>
    <?php } ?>
  </ul>

<div class="pagination-container">
    <div class="pagination" id="pagination">
        <?php for ($i = 1; $i <= min($pages, 3); $i++) { ?>
            <button id="pagination-button" class="pagination-button"><?= $i ?></button>
        <?php } ?>
        <?php if ($pages > 4) { ?>
            <button id="pagination-button" class="pagination-button">&#8594;</button>
        <?php } ?>
    </div>

    <select id="itemsPerPage" onchange="changeItemsPerPage()">
        <option value="8">8 per page</option>
        <option value="16">16 per page</option>
        <option value="32">32 per page</option>
    </select>
</div>


<?php }?>

<?php function drawItem(Item $item, PDO $db) { ?>
    <section class="row">
        <section id="images" class="col-2">
            <?php
                $images = Image::getImages($db, $item->itemId);
                $mainImage = $images[0];
            ?>

            <div class="sideImagesContainer">
                    <?php foreach($images as $image) { ?>
                        <img src="/<?= $image->path ?>" id="<?= $image->id ?>" class="sideImage">
                    <?php } ?>
            </div>

            <div class="main_image">
                <img src="/<?= $mainImage->path ?>" id="mainImage" data-id="<?= $mainImage->id ?>">
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
            <?php $condition = Condition::getCondition($db, $item->condition); ?>
            <p>Condition: <span id="conditionValue"><?=$condition->conditionVal?></span></p>

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
                    <img src= "/<?= $user->profilePic ?>">
                </div>

                <div class="sellerDetails">
                    <p class="username"><?=$user->username ?></p>
                    <p class="name"><?=$user->name ?></p>
                </div>

                <button class="sendMessageButton">
                    <p>Send Message</p>
                </button>

            </section>
        </div>
    </section>
<?php } ?>

