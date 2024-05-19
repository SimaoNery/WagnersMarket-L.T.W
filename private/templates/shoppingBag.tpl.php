<?php
declare(strict_types = 1);
?>


<?php function drawSummary(float $subTotal, float $shippingCosts) { ?>
    <section id="summary">
        <section id="summary-title">
            <h3>
                Summary
            </h3>
        </section>

        <section id="money-information">
            <h3 class="subtotal">Subtotal: </h3>
            <p id="subtotal-span"> <?= $subTotal ?> €</p>
            <h3 class="shipping-cost">Shipping Costs: </h3>
            <p id="shippingcost-span"> <?= $shippingCosts ?> €</p>
            <h3 class="total">Total:  </h3>
            <p id="total-span"> <?= $subTotal + $shippingCosts ?> €</p>

            <a href="../pages/checkout.php" class="checkout-button">
                Checkout
            </a>

        </section>
    </section>


<?php } ?>


