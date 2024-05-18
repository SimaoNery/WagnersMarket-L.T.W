<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if(!$session->isLoggedIn()) {
    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    $redirectUrl .= (!str_contains($redirectUrl, '?') ? '?' : '&') . 'showLogin=true';
    header("Location: " . $redirectUrl);
    exit();
}

require_once(__DIR__ . '/../../private/database/connection.db.php');
require_once(__DIR__ . '/../../private/database/item.class.php');
require_once(__DIR__ . '/../../private/database/cart.class.php');

require_once(__DIR__ . '/../../private/templates/common.tpl.php');
require_once(__DIR__ . '/../../private/templates/item.tpl.php');
require_once(__DIR__ . '/../../private/templates/profile.tpl.php');
require_once(__DIR__ . '/../../private/templates/checkout.tpl.php');

$limit = 4;
$offset = 0;
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
drawTitle("Checkout");
if($numItems === 0) :?>
    <p id="emptyShoppingBag"> Your shopping bag is empty!</p>

<?php else :
    drawDeliveryOptions();
    drawPaymentOptions();
    drawInYourBag($subTotal, $shippingCost, $items); ?>
<?php endif;

drawFooter();
?>

