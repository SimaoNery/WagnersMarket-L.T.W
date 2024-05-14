function removeFromShoppingBag(itemId) {
    let request = new XMLHttpRequest();
    request.open("POST", "../actions/action_remove_from_shopping_bag.php?id=" + itemId, true);
    request.onload = function () {

        let button = document.querySelector('.bag-button');

        button.innerHTML = '<i class="fa-solid fa-bag-shopping"></i> Add To Bag';
        button.onclick = function() {
                addToShoppingBag(itemId);
        };
    };

    request.send();
}

function addToShoppingBag(itemId) {
    let  request = new XMLHttpRequest();
    request.open("POST", "../actions/action_add_to_shopping_bag.php?id=" + itemId, true);
    request.onload = function () {

        let button = document.querySelector('.bag-button');
        // Update only the text content, keeping the icon intact
        button.innerHTML = '<i class="fa-solid fa-bag-shopping"></i> Remove From Bag';
        button.onclick = function() {
            removeFromShoppingBag(itemId);
        };
    };

    request.send();
}