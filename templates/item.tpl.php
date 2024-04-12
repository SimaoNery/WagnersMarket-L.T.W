<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php')
?>

<?php function drawItems(array $items) { ?>
  <header>
    <h2>Featured Items</h2>
  </header>
  <section id="items">
    <?php foreach($items as $item) { ?> 
      <article>

      </article>
    <?php } ?>
  </section>
<?php }?>
