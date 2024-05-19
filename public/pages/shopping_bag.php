<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/cart.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/item.tpl.php');
require_once(__DIR__ . '/../../private/templates/profile.tpl.php');
require_once(__DIR__ . '/../../private/templates/shoppingBag.tpl.php');

$db = getDatabaseConnection();

$userId = $session->getId();
$items = Item::getShoppingBag($db, $userId);
$numItems = Item::getNumItemsShoppingBag($db, $userId);

$subTotal = 0;
$shippingCost = 0;

foreach($items as $item) {
    $subTotal += $item->price;

    switch($item->size) {
        case "Small":
            $shippingCost += 2.5;
            break;
        case "Medium":
            $shippingCost += 4;
            break;
        case "Large":
            $shippingCost += 6;
            break;
    }
}

drawHeader($db, $session);
if($numItems === 0) :?>
    <p id="empty-shopping-bag"> Your shopping bag is empty!</p>

<?php else :
    drawBag($db, $userId, $items);
    drawSummary($subTotal, $shippingCost); ?>
<?php endif;

drawFooter();
?>

