<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php');
  require_once(__DIR__ . '/../database/image.class.php');
?>

<?php function drawItems(array $items, PDO $db) { ?>
  <header>
    <h2>Featured Items</h2>
  </header>
  <section id="items">
    <?php foreach($items as $item) { ?>
      <article>
          <a href="../pages/item.php?id=<?=$item->itemId?>"><?=$item->title?></a>
          <img src="<?= (Image::getImages($db, $item->itemId)[0])->path ?>" style="width: 100px; height: 100px;">
      </article>
    <?php } ?>
  </section>
<?php }?>
