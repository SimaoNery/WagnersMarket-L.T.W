const wishlistButtons = document.querySelectorAll('.wishlist-button')

if (wishlistButtons) {
    wishlistButtons.forEach(wishlistButton => {
        wishlistButton.addEventListener('click', async function(){

            const csrf = wishlistButton.querySelector(".csrf").value

            const heartIcon = this.querySelector('i.fa-heart')
            if (this.id !== 'not-logged-in') {
                if (heartIcon) {
                    if (heartIcon.classList.contains('fa-solid')) {
                        await removeFromWishlist(this.id, csrf, heartIcon)

                    } else {
                        await addToWishlist(this.id, csrf, heartIcon);

                    }
                }
            }
        });
    });
}



async function removeFromWishlist(itemId, csrf, heartIcon) {
    await fetch('../actions/action_remove_from_wishlist.php', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({itemId: itemId, csrf: csrf}),

    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                heartIcon.classList.remove('fa-solid')
                heartIcon.classList.add('fa-regular')
                showMessage(data.success, true);
            }
            else {
                showMessage(data.error, false);
            }
        })
        .catch(error => {
            console.error('Error:', error)
        })
}

async function addToWishlist(itemId, csrf, heartIcon) {
    await fetch('../actions/action_add_to_wishlist.php', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: encodeForAjax({itemId: itemId, csrf: csrf}),

    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                heartIcon.classList.remove('fa-regular')
                heartIcon.classList.add('fa-solid')
                showMessage(data.success, true);
            }
            else {
                showMessage(data.error, false);
            }
        })
        .catch(error => {
            console.error('Error:', error)
        })
}
