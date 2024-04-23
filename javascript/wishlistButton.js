function updateWishlistButton(isInWishlist) {
    let button = document.getElementById('wishlistButton');
    let icon = document.getElementById('wishlistIcon');

    if (isInWishlist) {
        button.classList.add('item-in-wishlist');
        icon.classList.remove('fa-regular');
        icon.classList.add('fa-solid');
    }
    else {
        button.classList.remove('item-in-wishlist');
        icon.classList.remove('fa-solid');
        icon.classList.add('fa-regular');
    }
}