<s?php
declare(strict_types = 1);
?>


<?php function drawSummary(float $subTotal, float $shippingCosts) { ?>
        <section id="shopping-bag-summary">
            <section id="summary-title">
                <h2>
                    Summary
                </h2>
            </section>

            <section id="money-information">
                <h4 class="subtotal">Subtotal: <span id="subtotal-span"> <?= $subTotal ?> €</span> </h4>
                <h4 class="shipping-cost">Shipping Costs: <span id="shipping-cost-span"> <?= $shippingCosts ?> €</span> </h4>
                <h3 class="total">Total: <span id="total-span"> <?= $subTotal + $shippingCosts ?> €</span> </h3>

                <a href="../pages/checkout.php" class="checkout-button">
                    Checkout
                </a>
            </section>
        </section>
</section>

<?php } ?>


