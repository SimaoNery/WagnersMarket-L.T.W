function removeFromWishlist(itemId, heartIcon) {
    let request = new XMLHttpRequest();
    request.open("POST", "../actions/action_remove_from_wishlist.php?id=" + itemId, true);
    request.onload = function () {
        heartIcon.className = "fa-regular fa-heart";

        heartIcon.parentElement.onclick = function() {
            addToWishlist(itemId, heartIcon);
        };
    };
    request.send();
}

function addToWishlist(itemId, heartIcon) {
    let request = new XMLHttpRequest();
    request.open("POST", "../actions/action_add_to_wishlist.php?id=" + itemId, true);
    request.onload = function () {
        heartIcon.className = "fa-solid fa-heart";

        heartIcon.parentElement.onclick = function() {
            removeFromWishlist(itemId, heartIcon);
        };
    };
    request.send();
}
