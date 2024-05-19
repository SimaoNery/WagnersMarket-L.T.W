const shoppingBagButton = document.querySelector('.bag-button');


if (shoppingBagButton) {
    shoppingBagButton.addEventListener('click', async function(){
        const csrf = shoppingBagButton.querySelector(".csrf").value
        if (this.id !== 'not-logged-in') {
            if (shoppingBagButton.classList.contains('remove-from-bag')) {
                await removeFromShoppingBag(this.id, false, csrf);
            } else {
                await addToShoppingBag(this.id, csrf);
            }
        }
    })
}

const trashButtons = document.querySelectorAll('.trash-button')

if (trashButtons) {
    trashButtons.forEach(trashButton => {
        const csrf = trashButton.querySelector(".csrf").value
        trashButton.addEventListener('click', async function() {
            await removeFromShoppingBag(this.id, true, csrf);
        })
    })
}

async function removeFromShoppingBag(itemId, inShoppingBag, csrf) {
    await fetch('../actions/action_remove_from_shopping_bag.php', {
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
                if (!inShoppingBag) handleOutsideShoppingBag(csrf)
                else handleInsideShoppingBag(itemId.toString())
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

async function handleOutsideShoppingBag(csrf) {
    const shoppingBagIcon = shoppingBagButton.querySelector('i.fa-bag-shopping');
    shoppingBagButton.innerHTML = "";

    const inputCsrf = document.createElement('input')
    inputCsrf.type = 'hidden'
    inputCsrf.name = 'csrf'
    inputCsrf.classList.add('csrf')
    inputCsrf.value = csrf

    shoppingBagButton.append(inputCsrf)
    shoppingBagButton.append(shoppingBagIcon);
    shoppingBagButton.classList.remove("remove-from-bag");
    shoppingBagButton.classList.add("add-to-bag");
    shoppingBagButton.innerHTML += "Add to Cart";
}

async function handleInsideShoppingBag(itemId) {
    const li = document.querySelector("li#item-" + itemId)

    if (li) {
        const ul = document.querySelector('.draw-bag')
        const parent = document.querySelector('.draw-bag')
        li.remove()

        if (ul.children.length === 0) {
            const shoppingBag = document.getElementById('shopping-bag-page');
            if (shoppingBag) {
                shoppingBag.innerHTML = ""
            }
            
            const p = document.createElement('p')
            p.innerHTML = "Your shopping bag is empty!"
            p.id = "empty-shopping-bag"

            shoppingBag.append(p)
            ul.remove()
        }
    }
}


async function addToShoppingBag(itemId, csrf) {

    await fetch('../actions/action_add_to_shopping_bag.php', {
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
                const shoppingBagIcon = shoppingBagButton.querySelector('i.fa-bag-shopping');
                shoppingBagButton.innerHTML = ''

                const inputCsrf = document.createElement('input')
                inputCsrf.type = 'hidden'
                inputCsrf.name = 'csrf'
                inputCsrf.classList.add('csrf')
                inputCsrf.value = csrf

                shoppingBagButton.append(inputCsrf)
                shoppingBagButton.append(shoppingBagIcon)
                shoppingBagButton.classList.remove("remove-from-bag")
                shoppingBagButton.classList.add("remove-from-bag")
                shoppingBagButton.innerHTML += "Remove from Cart"
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