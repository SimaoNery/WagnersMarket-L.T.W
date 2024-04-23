function removeFromWishlist(itemId) {
    let request = new XMLHttpRequest();
    request.open("POST", "../actions/action_remove_from_wishlist.php?id=" + itemId, true);
    request.onload = function () {

        document.getElementById("wishlistIcon").className = "fa-regular fa-heart";

        document.querySelector('.wishlist-button').onclick = function() {
            addToWishlist(itemId);
        };
    };

    request.send();
}

function addToWishlist(itemId) {
    let  request = new XMLHttpRequest();
    request.open("POST", "../actions/action_add_to_wishlist.php?id=" + itemId, true);
    request.onload = function () {

        document.getElementById("wishlistIcon").className = "fa-solid fa-heart";

        document.querySelector('.wishlist-button').onclick = function() {
            removeFromWishlist(itemId);
        };
    };

    request.send();
}