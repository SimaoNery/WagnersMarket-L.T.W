<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php');
  require_once(__DIR__ . '/../database/image.class.php');
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

