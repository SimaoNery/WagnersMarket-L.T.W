const shoppingBagButton = document.querySelector('.bag-button');


if (shoppingBagButton) {
    shoppingBagButton.addEventListener('click', async function(){
        if (this.id !== 'not-logged-in') {
            if (shoppingBagButton.classList.contains('remove-from-bag')) {
                await removeFromShoppingBag(this.id, false);
            } else {
                await addToShoppingBag(this.id);
            }
        }
    })
}

const trashButtons = document.querySelectorAll('.trash-button')

if (trashButtons) {
    trashButtons.forEach(trashButton => {
        trashButton.addEventListener('click', async function() {
            await removeFromShoppingBag(this.id, true);
        })
    })
}

function removeFromShoppingBag(itemId, inShoppingBag) {
    const params = new URLSearchParams()
    params.append('itemId', itemId.toString())

    let request = new XMLHttpRequest();
    request.open("POST", "../actions/action_remove_from_shopping_bag.php", true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {
        if (!inShoppingBag) handleOutsideShoppingBag(request.responseText)
        else handleInsideShoppingBag(request.responseText, itemId.toString())
    }

    request.send(params.toString())
}

function handleOutsideShoppingBag(responseText) {
    const response = JSON.parse(responseText);
    if (response.success) {
        const shoppingBagIcon = shoppingBagButton.querySelector('i.fa-bag-shopping');
        shoppingBagButton.innerHTML = "";
        shoppingBagButton.append(shoppingBagIcon);
        shoppingBagButton.classList.remove("remove-from-bag");
        shoppingBagButton.classList.add("add-to-bag");
        shoppingBagButton.innerHTML += "Add to Cart";
    }
}

function handleInsideShoppingBag(responseText, itemId) {
    const response = JSON.parse(responseText);
    if (response.success) {
        const li = document.querySelector("li#item-" + itemId)

        if (li) {
            const ul = document.querySelector('.draw-bag')
            const parent = document.querySelector('.draw-bag')
            li.remove()

            if (ul.children.length === 0) {
                const p = document.createElement('p')
                p.innerHTML = "Your shopping bag is empty!"
                p.id = "empty-shopping-bag"

                ul.insertAdjacentElement('afterend', p)
                ul.remove()
                const summary = document.getElementById('summary')
                if (summary) summary.remove()
            }
        }
    }
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