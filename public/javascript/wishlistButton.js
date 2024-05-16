const wishlistButtons = document.querySelectorAll('.wishlist-button')

if (wishlistButtons) {
    wishlistButtons.forEach(wishlistButton => {
        wishlistButton.addEventListener('click', async function(){
            const heartIcon = this.querySelector('i.fa-heart')
            if (this.id !== 'not-logged-in') {
                if (heartIcon) {
                    if (heartIcon.classList.contains('fa-solid')) {
                        await removeFromWishlist(this.id)
                        heartIcon.classList.remove('fa-solid')
                        heartIcon.classList.add('fa-regular')
                    } else {
                        await addToWishlist(this.id);
                        heartIcon.classList.remove('fa-regular')
                        heartIcon.classList.add('fa-solid')
                    }
                }
            }
        });
    });
}



async function removeFromWishlist(itemId) {
    const params = new URLSearchParams()
    params.append('itemId', itemId.toString())

    let request = new XMLHttpRequest();
    request.open("POST", "../actions/action_remove_from_wishlist.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {
        const response = JSON.parse(request.responseText)
    }
    request.send(params.toString())
}

function addToWishlist(itemId) {
    const params = new URLSearchParams()
    params.append('itemId', itemId.toString())

    const  request = new XMLHttpRequest()
    request.open("POST", "../actions/action_add_to_wishlist.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    request.onload = function () {
        const response = JSON.parse(request.responseText)

    }
    request.send(params.toString())
}
