const shoppingBagButton = document.querySelector('.bag-button');


if (shoppingBagButton) {
    shoppingBagButton.addEventListener('click', async function(){
        if (this.id !== 'not-logged-in') {
            if (shoppingBagButton.classList.contains('remove-from-bag')) {
                await removeFromShoppingBag(this.id);
            } else {
                await addToShoppingBag(this.id);
            }
        }
    })
}


function removeFromShoppingBag(itemId) {
    const params = new URLSearchParams()
    params.append('itemId', itemId.toString())

    let request = new XMLHttpRequest();
    request.open("POST", "../actions/action_remove_from_shopping_bag.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {

        const response = JSON.parse(request.responseText)
        if (response.success) {
            const shoppingBagIcon = shoppingBagButton.querySelector('i.fa-bag-shopping');
            shoppingBagButton.innerHTML = ""
            shoppingBagButton.append(shoppingBagIcon)
            shoppingBagButton.classList.remove("remove-from-bag")
            shoppingBagButton.classList.add("add-to-bag")
            shoppingBagButton.innerHTML += "Add to Cart"
        }
    }

    request.send(params.toString())
}

function addToShoppingBag(itemId) {
    const params = new URLSearchParams()
    params.append('itemId', itemId.toString())

    let request = new XMLHttpRequest();
    request.open("POST", "../actions/action_add_to_shopping_bag.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {
        const response = JSON.parse(request.responseText)
        if (response.success) {
            const shoppingBagIcon = shoppingBagButton.querySelector('i.fa-bag-shopping');
            shoppingBagButton.innerHTML = ""
            shoppingBagButton.append(shoppingBagIcon)
            shoppingBagButton.classList.remove("remove-from-bag")
            shoppingBagButton.classList.add("remove-from-bag")
            shoppingBagButton.innerHTML += "Remove from Cart"
        }
    }

    request.send(params.toString())
}