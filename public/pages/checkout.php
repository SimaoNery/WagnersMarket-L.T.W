<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/denied.php');
    handleBadAccess("You don't have permission to access this page!", $session);
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

$subTotal = 0;
$shippingCost = 0;

foreach($items as $item) {
    $subTotal += $item->price;
}

if ($subTotal <= 5) {
    $shippingCost = 5;
}
else if ($subTotal >= 100) {
    $shippingCost = 0;
}
else {
    $shippingCost = 5 + ($subTotal * 0.03);
    $shippingCost = min(15, $shippingCost);
}

$shippingCost = round($shippingCost, 2);

drawHeader($db, $session);
drawTitle("Checkout");
if(empty($items)) :?>
    <p id="empty-shopping-bag"> Your shopping bag is empty!</p>

<?php else :
    drawDeliveryOptions();
    drawPaymentOptions();
    drawInYourBag($subTotal, $shippingCost, $items); ?>
<?php endif;

drawFooter();
?>

