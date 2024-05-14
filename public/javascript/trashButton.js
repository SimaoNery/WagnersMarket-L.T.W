function trashBagItem(itemId) {
    let request = new XMLHttpRequest();
    request.open('POST', '../actions/action_remove_from_shopping_bag.php?id=' + itemId, true);
    request.onload = function() {
        location.reload();
    }

    request.send();
}