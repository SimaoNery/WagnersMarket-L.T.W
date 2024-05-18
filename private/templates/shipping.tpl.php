<?php
declare(strict_types = 1);
?>

<?php function drawDate() { ?>
    <h2>Date:</h2>
<?php } ?>

<?php function drawShipping() { ?>
    <h2>
        Sender
    </h2>
    <section class="sender-info">
        <input type="text" id="sender-name" name="sender-name" placeholder="Name" required>
        <label for="sender-name">Name:</label>

        <input type="text" id="sender-country" name="sender-country" placeholder="Country" required>
        <label for="sender-country">Country:</label>

        <input type="text" id="sender-number" name="sender-number" placeholder="Phone Number" required>
        <label for="sender-number">Phone:</label>

        <input type="text" id="sender-address" name="sender-address" placeholder="Address" required>
        <label for="sender-address">Address:</label>
    </section>

    <h2>
        Receiver
    </h2>
    <section class="receiver-info">
        <input type="text" id="receiver-name" name="receiver-name" placeholder="Name" required>
        <label for="receiver-name">Name:</label>

        <input type="text" id="receiver-country" name="receiver-country" placeholder="Country" required>
        <label for="receiver-country">Country:</label>

        <input type="text" id="receiver-number" name="receiver-number" placeholder="Phone Number" required>
        <label for="receiver-number">Phone:</label>

        <input type="text" id="receiver-address" name="receiver-address" placeholder="Address" required>
        <label for="receiver-address">Address:</label>
    </section>

    <h2>
        Item Description
    </h2>
    <input type="text" id="item-description" name="item-description" placeholder="Item Description" required>

    <button class="print-button">
        Print
    </button>

    <h2>
        Shipping Device
    </h2>
    <section class="shipping-service">
        <input type="radio" id="CTT" name="CTT" value="CTT" required>
        <label for="CTT">CTT</label>

        <input type="radio" id="UPS" name="UPS" value="UPS" required>
        <label for="UPS">UPS</label>
    </section>
<?php } ?>
