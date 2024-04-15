<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php');
  require_once(__DIR__ . '/../database/image.class.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/condition.class.php');
?>

<?php function drawItems(array $items, PDO $db) { ?>
  <section id="categories">
      <h2>
          Most Popular
      </h2>
      <hr class="line-yellow">
  </section>
  <ul class="most-popular">
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
<?php }?>

<?php function drawItem(Item $item, PDO $db) { ?>
    <section id="information">
        <article>
            <h1><?=$item->title?></h1>
            <?=number_format($item->price, 2)?>€
            <i class="fa-regular fa-heart"></i>
            <i class="fa-solid fa-bag-shopping"></i>Add To Cart
        </article>

        <h3>Product Details</h3>
        <p>Brand: <?=$item->brand?></p>
        <?php $condition = Condition::getCondition($db, $item->condition); ?>
        <p>Condition: <?=$condition->conditionVal ?></p>
    </section>

    <section id="images">
        <?php $images = Image::getImages($db, $item->itemId); ?>
        <?php foreach($images as $image) { ?>
            <img src= "/<?= $image->path ?>" style="width: 100px; height: 100px;">
        <?php } ?>
    </section>

    <section id="description&seller">
        <h2>Product Description</h2>
        <?=$item->description?>

        <h2>Contact the seller</h2>
        <?php $user = User::getUser($db, $item->userId); ?>
        <img src= "/<?= $user->profilePic ?>" style="width: 100px; height: 100px;">
        <?=$user->username ?>
        <?=$user->name ?>
        <?=$user->email ?>

        <p>Send Message</p>
    </section>
<?php } ?>

