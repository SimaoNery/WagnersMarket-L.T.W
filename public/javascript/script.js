const searchItem = document.querySelector('#search-items')
const categories = document.querySelectorAll('#category input[type="checkbox"]')
const conditions = document.querySelectorAll('#condition input[type="checkbox"]')
const minInput = document.querySelector('#min-input')
const maxInput = document.querySelector('#max-input')
const minRange = document.querySelector('#min-range')
const maxRange = document.querySelector('#max-range')
const orderSelected = document.querySelector('#orderSelected')

const range = document.querySelector("#slider #progress");

const filters = document.querySelector("#filters");

let selectedCategories = []
let selectedConditions = []
let searchedItem = ''
let numberOfItems = 16
let offsetOfItems = 0

if (categories) {
    categories.forEach(category => {
        category.addEventListener('change', async function() {
            numberOfItems = 16
            offsetOfItems = 0
            const categoryId = this.id
            if (this.checked) {

                if (!selectedCategories.includes(categoryId)) {
                    selectedCategories.push(categoryId)
                }
            } else {
                selectedCategories = selectedCategories.filter(catId => catId !== categoryId)
            }
            await getSearchResults()
        })
    })
}

if (conditions) {
    conditions.forEach(condition => {
        condition.addEventListener('change', async function() {
            numberOfItems = 16
            offsetOfItems = 0
            const conditionId = this.id;
            if (this.checked) {
                if (!selectedConditions.includes(conditionId)) {
                    selectedConditions.push(conditionId);
                }
            } else {
                selectedConditions = selectedConditions.filter(cId => cId !== conditionId);
            }
            await getSearchResults()
        })
    })
}

if (searchItem) {
    searchItem.addEventListener('input', async function() {
        numberOfItems = 16
        offsetOfItems = 0
        searchedItem = this.value
        await getSearchResults()
    })
}

if (minInput) {
    minInput.addEventListener('change', async function() {
        numberOfItems = 16
        offsetOfItems = 0
        minRange.value = this.value;
        range.style.left = (this.value / this.max) * 100 + '%'
        if (parseInt(maxInput.value) < parseInt(this.value)) {
            maxInput.value = this.value
            maxRange.value = this.value
        }
        await getSearchResults()
    });
}

if (minRange) {
    minRange.addEventListener('change', async function() {
        numberOfItems = 16
        offsetOfItems = 0
        minInput.value = this.value;
        range.style.left = (this.value / this.max) * 100 + '%'
        if (parseInt(maxInput.value) < parseInt(this.value)) {
            maxInput.value = this.value
            maxRange.value = this.value
        }
        await getSearchResults()
    });
}

if (maxInput) {
    maxInput.addEventListener('change', async function() {
        numberOfItems = 16
        offsetOfItems = 0
        maxRange.value = this.value;
        range.style.right = 100 - (this.value / this.max) * 100 + '%'
        if (parseInt(minInput.value) > parseInt(this.value)) {
            minInput.value = this.value;
            minRange.value = this.value;
        }
        await getSearchResults();
    });
}

if (maxRange) {
    maxRange.addEventListener('change', async function() {
        numberOfItems = 16
        offsetOfItems = 0
        maxInput.value = this.value;
        range.style.right = 100 - (this.value / this.max) * 100 + '%'
        if (parseInt(minInput.value) > parseInt(this.value)) {
            minInput.value = this.value;
            minRange.value = this.value;

        }
        await getSearchResults()
    });
}

if(orderSelected) {
    orderSelected.addEventListener('change', async function () {
        numberOfItems = 16
        offsetOfItems = 0
        await getSearchResults()
    });
}


if (filters) {
    const items = document.querySelector('#draw-items')
    if (items) {
        items.addEventListener('scroll', async function () {
            if (items.scrollHeight - items.scrollTop <= items.clientHeight + 20) {
                numberOfItems += 16
                offsetOfItems += 8
                await getSearchResults();
            }
        })
    }
}

async function getSearchResults() {

    let url = '../api/api_items.php?'
    let cat = selectedCategories.join(';');
    let cond = selectedConditions.join(';');
    let params = {search: searchedItem, category: cat, condition: cond, min: minInput.value, max: maxInput.value, order: orderSelected.value, limit: numberOfItems};
    url += new URLSearchParams(params).toString()

    const response = await fetch(url)

    let items = await response.json()

    const itemsSection = document.querySelector('#draw-items');
    itemsSection.innerHTML = ''

    if (!items.length) {
        const paragraph = document.createElement('p')
        paragraph.id = 'not-found'
        paragraph.textContent = 'No items found'
        itemsSection.appendChild(paragraph)
    }

    for (const item of items) {
        const itemElement = document.createElement('li');
        itemElement.classList.add('item-card');

        const linkElement = document.createElement('a');
        linkElement.href = `../pages/item.php?id=${item.itemId}`;

        const imageElement = document.createElement('img');
        imageElement.src = '/' + item.imagePath;
        imageElement.style.width = '100px';
        imageElement.style.height = '100px';

        const titleElement = document.createElement('h4');
        titleElement.textContent = item.title;

        const priceElement = document.createElement('p');
        const formattedPrice = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(item.price);

        const wishlistButton = document.createElement('button')

        wishlistButton.setAttribute('type', 'button')
        wishlistButton.classList.add('wishlist-button')
        wishlistButton.id = item.itemId

        const iconWishlistButton = document.createElement('i')

        if (notLoggedIn) {
            wishlistButton.id = "not-logged-in"
            wishlistButton.setAttribute("disabled", true)
            iconWishlistButton.classList.add("fa-regular", "fa-heart")
        } else if (await inWishlist(item.itemId)) {
            wishlistButton.id = item.itemId.toString()
            iconWishlistButton.classList.add("fa-solid", "fa-heart")
        } else {
            wishlistButton.id = item.itemId.toString()
            iconWishlistButton.classList.add("fa-regular", "fa-heart")
        }

        wishlistButton.append(iconWishlistButton)

        wishlistButton.addEventListener('click', async function(){
            if (this.id !== 'not-logged-in') {
                if (iconWishlistButton) {
                    if (iconWishlistButton.classList.contains('fa-solid')) {
                        await removeFromWishlist(this.id);
                        iconWishlistButton.classList.remove('fa-solid');
                        iconWishlistButton.classList.add('fa-regular');
                    } else {
                        await addToWishlist(this.id);
                        iconWishlistButton.classList.remove('fa-regular');
                        iconWishlistButton.classList.add('fa-solid');
                    }
                }
            }
        })

        priceElement.textContent = formattedPrice + '€';

        linkElement.appendChild(imageElement);
        linkElement.appendChild(titleElement);
        linkElement.appendChild(priceElement);
        itemElement.append(wishlistButton)
        itemElement.appendChild(linkElement);
        itemsSection.appendChild(itemElement);

    }
}






