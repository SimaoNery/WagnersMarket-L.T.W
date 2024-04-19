<?php 
  declare(strict_types = 1); 

  require_once(__DIR__ . '/../database/item.class.php');
?>

<?php function drawItems(array $items) { ?>
  <header>
    <h2>Featured Items</h2>
  </header>
  <section id="items">
    <?php foreach($items as $item) { ?>
      <article>
          <a href="../pages/item.php?id=<?=$item->itemId?>"><?=$item->title?></a>
          <img src="<?=$item->imagePath?>" style="width: 100px; height: 100px;">
      </article>
    <?php } ?>
  </section>
<?php }?>

<?php function drawSearchedItems(array $items) { ?>
    <header>
        <h2>Featured Items</h2>
        <input id="searchitem" type="text" placeholder="What are you looking for?">
    </header>
    <section id="items">
        <?php foreach($items as $item) { ?>
            <article>
                <a href="../pages/item.php?id=<?=$item->itemId?>"><?=$item->title?></a>
                <img src="/<?=$item->imagePath?>" style="width: 100px; height: 100px;">
            </article>
        <?php } ?>
    </section>
<?php }?>

<?php function shownItemsMaxPrice(array $items) {
    $max = PHP_FLOAT_MIN;
    foreach($items as $item) {
        if ($max < $item->price) {
            $max = $item->price;
        }
    }
    return $max;
}?>


<?php function drawItemFilter(array $items) { ?>
        <form id="filters">
            <fieldset id="price-range">
                <?php $maxPrice = shownItemsMaxPrice($items)?>
                <legend>Price Range</legend>
                <label>Min: <input type="number" id="min-input" value = "0" min="0" max="<?=$maxPrice?>"></label>
                <label>Max: <input type="number" id="max-input" value = "<?=$maxPrice?>" min="0" max="<?=$maxPrice?>"></label>
                <input type="range" id="min-range" min="0" max="<?=$maxPrice?>" value="0" step="1">
                <input type="range" id="max-range" min="0" max="<?=$maxPrice?>" value="<?=$maxPrice?>" step="1">
            </fieldset>
            <fieldset id="category">
                <legend>Category</legend>
                <label>Fashion <input type="checkbox" id="Fashion"></label>
                <label>Technology <input type="checkbox" id="Technology"></label>
                <label>Vehicles <input type="checkbox" id="Vehicles"></label>
                <label>Sports <input type="checkbox" id="Sports"></label>
                <label>Tools And Equipment <input type="checkbox" id="Tools And Equipment"></label>
                <label>Furniture and Home <input type="checkbox" id="FurnitureAndHome"></label>
                <label>Babies and Children <input type="checkbox" id="BabiesAndChildren"></label>
            </fieldset>
            <fieldset id="condition">
                <legend>Condition</legend>
                <label>New <input type="checkbox" id="New"></label>
                <label>Used <input type="checkbox" id="Used"></label>
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
