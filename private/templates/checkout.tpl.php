<?php
declare(strict_types = 1);
?>

<?php function drawDeliveryOptions() { ?>
    <section class="checkout-page">
    <section id="delivery-information">
        <h2 class="delivery-information-title">
            Delivery Information
        </h2>

        <section class="delivery-information-inputs">
            <input type="text" id="first-name" name="first-name" placeholder="First Name" required>

            <input type="text" id="last-name" name="last-name" placeholder="Last Name" required>

            <input type="text" id="address" name="address" placeholder="Address" required>

            <input type="text" id="postal-code" name="postal-code" placeholder="Postal Code" required>
        </section>
    </section>

<?php } ?>

<?php function drawPaymentOptions() { ?>
    <section id="payment-options">
        <h2 class="payment-options-title">
            Payment Options
        </h2>

        <section class="payment-options-inputs">
            <section class="card">
                <input type="radio" id="card" name="payment-option" value="card" required>
                <label for="card">Card</label>
            </section>

            <section class="mb-ways">
                <input type="radio" id="mb-way" name="payment-option" value="mb-way" required>
                <label for="mb-way">MB Way</label>
            </section>
        </section>

        <section class="card-info" style="display: none;">
            <input type="text" id="card-number" name="card-number" placeholder="Card Number" required>

            <input type="text" id="card-date" name="card-date" placeholder="MM/YY" required>

            <input type="text" id="cvv" name="cvv" placeholder="cvv" required>
        </section>

        <section class="mbway-info" style="display: none;">
            <input type="text" id="phone-number" name="phone-number" placeholder="Phone Number" required>
        </section>

        <button id="confirm-order" style="display: none">Confirm Order</button>
        <a href="../pages/shopping_bag.php" class="cancel-button button" style="display: none">Cancel</a>

    </section>

<?php } ?>

<?php function drawInYourBag(float $subTotal, float $shippingCosts, array $items) { ?>
    
        <section id="in-your-bag">
            <section id="in-your-bag-header">
                <h2 id="in-your-bag-title">
                    In Your Bag
                </h2>

                <a href="../pages/shopping_bag.php" class="shopping-bag-edit">Edit</a>
            </section>

            <section id="in-your-bag-money-information">
                <h4 class="subtotal-checkout">Subtotal: <span id="subtotal-span-checkout"> <?= $subTotal ?> €</span> </h4>
                <h4 class="shipping-cost-checkout">Shipping Costs: <span id="shipping-cost-span-checkout"> <?= $shippingCosts ?> €</span> </h4>

                <h3 class="total-checkout"  >Total: <span id="total-span-checkout"> <?= $subTotal + $shippingCosts ?> €</span> </h3>

                <section class="checkout-items-container">
                    <ul class="draw-in-your-bag">
                        <?php foreach($items as $item) { ?>
                            <li class="items-checkout-card" data-item-id="<?= $item->itemId ?>">
                                <a href="../pages/item.php?id=<?=$item->itemId?>">
                                    <img src="<?= $item->imagePath?>" class="bagItemImage-checkout">
                                </a>

                                <a href="../pages/item.php?id=<?=$item->itemId?>">
                                    <h4 class="bag-item-title-checkout"><?=$item->title?></h4>
                                    <p class="bag-item-brand-checkout">Brand: <span id="brand-name"><?=$item->brand?></span></p>
                                    <p class="bag-item-condition-checkout">Condition: <span id="condition-value"><?=$item->condition?></span></p>
                                    <p class="bag-item-price-checkout"><?=number_format($item->price, 2)?>€</p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </section>
            </section>
        </section>

        <section id="success-message" style="display: none;">
            <p>Checkout successful!</p>
            <input class="csrf" id="csrf" type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
            <input class="user-id" id="user-id" type="hidden" name="user-id" value="<?= $_SESSION['id'] ?>">
            <button id="close-button">Close</button>
        </section>

    </section>

<?php } ?>