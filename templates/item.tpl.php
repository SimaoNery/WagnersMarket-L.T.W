<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php');
  require_once(__DIR__ . '/../database/image.class.php');
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


<div class="pagination">
    <?php for ($i = 1; $i <= min($pages, 3); $i++) { ?>
        <button onclick="fetchItems($limit, <?= ($i - 1) * 4 ?>)" class="pagination-button"><?= $i ?></button>
    <?php } ?>
    <?php if ($pages > 4) { ?>
        <button onclick="fetchItems($limit, <?= ($pages - 1) * 4 ?>)" class="pagination-button">&#8594;</button>
    <?php } ?>
</div>

<select id="itemsPerPage" onchange="changeItemsPerPage()">
    <option value="8">8 per page</option>
    <option value="16">16 per page</option>
    <option value="32">32 per page</option>
</select>


<?php }?>

