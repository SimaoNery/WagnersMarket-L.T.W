<?php
declare(strict_types = 1);
?>

<?php function drawPublishForm(array $categories, array $sizes, array $conditions) : void { ?>
        <section class="container">
            <form id="publish" action="../../public/actions/action_publish_add.php" method="post" enctype="multipart/form-data">
                <fieldset id="item-info">
                    <h3>More details are better!</h3>
                    <label>Title*<textarea name="title" placeholder="Think of a catchy title" maxlength="70" rows="2" cols="70" required="required"></textarea></label>
                    <label>Description*<textarea name="description" placeholder="Write what you would like to read if you saw this ad" maxlength="9000" rows="4" cols="50" required="required"></textarea></label>
                    <label>Price* <input type="number" name="price" step="0.01" placeholder="Choose the item's price" required="required"></label>
                </fieldset>

                <fieldset id="item-condition-size">
                    <h3>What's your item's condition and package size?</h3>
                    <label>Condition*
                        <select name="condition" required="required">
                            <?php foreach($conditions as $condition) { ?>
                                <option value="<?= $condition->condition ?>"><?= $condition->condition ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <label>Size*
                        <select name="size" required="required">
                            <?php foreach($sizes as $size) { ?>
                                <option value="<?= $size->size ?>"><?= $size->size ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </fieldset>

                <fieldset id="item-brand-categories">
                    <h3>Some additional info: What's your items brand? Which categories does it fit into?</h3>
                    <label>Brand: <textarea name="brand" placeholder="What brand is your item?" maxlength="50" rows="1" cols="50" required="required"></textarea></label>
                    <section id="categories">
                        <?php foreach($categories as $category) { ?>
                            <label><?= $category->categoryName ?> <input type="checkbox" name="categories[]" value="<?= $category->categoryName ?>"></label>
                        <?php } ?>
                    </section>
                </fieldset>

                <fieldset id="pictures">
                    <h3>Take a few pictures of your item!</h3>
                    <section id="upload">
                        <label>Upload a cover image*<input type="file" name="images[]" accept="image/png,image/jpeg" required="required"></label>
                        <label>Upload an image<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
                        <label>Upload an image<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
                        <label>Upload an image<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
                        <label>Upload an image<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
                        <label>Upload an image<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
                        <label>Upload an image<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
                        <label>Upload an image<input type="file" name="images[]" accept="image/png,image/jpeg"></label>
                    </section>

                </fieldset>

                <input type="submit" value="Publish add">
            </form>
        </section>



<?php } ?>

