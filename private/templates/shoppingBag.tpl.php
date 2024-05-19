<?php
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
                <h4 class="subtotal">Subtotal: <p id="subtotal-span"> <?= $subTotal ?> €</p> </h4>
                <h4 class="shipping-cost">Shipping Costs: <p id="shipping-cost-span"> <?= $shippingCosts ?> €</p> </h4>
                <h3 class="total">Total: <p id="total-span"> <?= $subTotal + $shippingCosts ?> €</p> </h3>

                <a href="../pages/checkout.php" class="checkout-button">
                    Checkout
                </a>
            </section>
        </section>
</section>


<?php } ?>


