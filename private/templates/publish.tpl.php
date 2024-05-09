<?php
declare(strict_types = 1);
?>

<?php function drawPublishForm(array $categories, array $sizes, array $conditions) : void { ?>
    <form id="publish" action="../../public/actions/action_publish_add.php" method="post" enctype="multipart/form-data">
        <fieldset id="item-info">
            <legend>More details are better!</legend>
            <label>Title: <input type="text" name="title" placeholder="Think of a catchy title" required="required"></label>
            <label>Description: <input type="text" name="description" placeholder="Write what you would like to read if you saw this ad" required="required"></label>
            <label>Brand: <input type="text" name="brand" placeholder="What brand is your item?"></label>
            <label>Price: <input type="number" name="price" step="0.01" placeholder="Choose the item's price" required></label>
        </fieldset>

        <fieldset id="item-condition">
            <legend>What's your item's condition</legend>
            <label>Condition:
                <select name="condition">
                    <?php foreach($conditions as $condition) { ?>
                        <option value="<?= $condition->condition ?>"><?= $condition->condition ?></option>
                    <?php } ?>
                </select>
            </label>
        </fieldset>

        <fieldset id="package-size">
            <legend>What's the package size?</legend>
            <label>Size:
                <select name="size">
                    <?php foreach($sizes as $size) { ?>
                        <option value="<?= $size->size ?>"><?= $size->size ?></option>
                    <?php } ?>
                </select>
            </label>
        </fieldset>



        <fieldset id="categories">
            <legend>What categories does your item belong to?</legend>
            <?php foreach($categories as $category) { ?>
                <label><?= $category->categoryName ?><input type="checkbox" name="categories[] value="<?= $category->categoryName ?>""></label>
            <?php } ?>
        </fieldset>

        <fieldset id="pictures">
            <legend>Take a few pictures of your item!</legend>
            <label>Add an image<input type="file" name="images[]" accept="image/png,image/jpeg" required="required"></label>
            <label>+<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
            <label>+<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
            <label>+<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
            <label>+<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
            <label>+<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
            <label>+<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
            <label>+<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
        </fieldset>

        <fieldset id="Location">
            <legend>Location</legend>
            <label>Title: <input type="text" name="location" placeholder="Parish or postal code" required="required"></label>
        </fieldset>

        <label>Publish add<input type="submit" value="Send"></label>
    </form>

<?php } ?>

