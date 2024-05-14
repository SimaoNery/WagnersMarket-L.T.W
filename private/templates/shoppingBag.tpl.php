<?php
declare(strict_types = 1);
?>


<?php function drawSummary(float $subTotal, float $shippingCosts) { ?>
    <section class="shopping-bag-page2">
        <section id="shoppingbag-info">
            <section id="summary-title">
                <h2>
                    Summary
                </h2>
            </section>

            <section id="money-information">
                <h4 class="subtotal">Subtotal: <span id="subtotal-span"> <?= $subTotal ?> €</span> </h4>
                <h4 class="shipping-cost">Shipping Costs: <span id="shippingcost-span"> <?= $shippingCosts ?> €</span> </h4>
                <h3 class="total">Total: <span id="total-span"> <?= $subTotal + $shippingCosts ?> €</span> </h3>

                <a href="../pages/checkout.php" class="checkout-button">
                    Checkout
                </a>

            </section>
        </section>
    </section>

<?php } ?>


