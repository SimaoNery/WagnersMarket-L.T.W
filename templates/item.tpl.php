<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php')
?>

<?php function drawItems(array $items) { ?>
  <header>
    <h2>Anúncios</h2>
    <input id="searchadd" type="text" placeholder="O que procuras?">
  </header>
  <section id="items">
    <?php foreach($items as $item) { ?> 
      <article>
        <img src="https://picsum.photos/200?<?=$item->id?>">
        <a href="../pages/item.php?id=<?=$item->id?>"><?=$item->name?></a>
      </article>
    <?php } ?>
  </section>
<?php }?>
