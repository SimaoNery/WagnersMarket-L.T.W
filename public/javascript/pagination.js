const paginationContainer = document.querySelector('.pagination');
const itemsPerPageContainer = document.querySelector('#items-per-page');
//const notLoggedIn = document.querySelector('.not-logged-in')

let limit = 8;
let offset = 0;
let pageNumber = 1;
let firstButtonValue = 1;


if (paginationContainer) {
    paginationContainer.addEventListener('click', function(event) {
        if (event.target.tagName === 'BUTTON') {
            const buttonId = event.target.id;
    
            if (buttonId === 'pagination-button') {
                pageNumber = parseInt(event.target.textContent);
            } else if (buttonId === 'next-button') {
                pageNumber = firstButtonValue === 1 ? 4 : pageNumber + 2;
                firstButtonValue = pageNumber;
            }
            else if (buttonId === 'previous-button') {
                pageNumber = firstButtonValue === 4 ? 1 : pageNumber - 2;
                firstButtonValue = pageNumber;
            }
    
            offset = (pageNumber - 1) * limit;
    
            fetchItems(limit, offset, paginationContainer.id);
        }
    })
}

if (itemsPerPageContainer) {
    itemsPerPageContainer.addEventListener('change', function(event) {
        let lastLimit = limit;

        limit = parseInt(itemsPerPageContainer.value);
        
        const conversationFactor = lastLimit / limit;

        pageNumber = pageNumber * conversationFactor;

        offset = (pageNumber - 1) * limit;
        
        fetchItems(limit, offset, paginationContainer.id);
    });
}

function fetchItems(limit, offset, searchType) {
    const xhr = new XMLHttpRequest();
    switch(searchType) {
        case "most_popular":
            xhr.open('GET', `../api/api_dennis.php?limit=${limit}&offset=${offset}`, true);
            break;
        case "wishlist":
            xhr.open('GET', `../api/api_wishlist_pagination.php?limit=${limit}&offset=${offset}`, true);
            break;
        case "your_adds":
            xhr.open('GET', `../api/api_yourAdds.php?limit=${limit}&offset=${offset}`, true);
            break;
    }

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            try {
                const response = JSON.parse(xhr.responseText);

                const items = response.items;
                const itemsContainer = document.querySelector('#draw-items');
                itemsContainer.innerHTML = '';
                items.forEach(async item => {
                    const itemElement = document.createElement('li');
                    itemElement.classList.add('item-card');

                    const linkElement = document.createElement('a');
                    linkElement.href = `../pages/item.php?id=${item.itemId}`;

                    const imageElement = document.createElement('img');
                    imageElement.src = item.imagePath;

                    const titleElement = document.createElement('h4');
                    titleElement.textContent = item.title;

                    const priceElement = document.createElement('p');
                    const formattedPrice = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(item.price);

                    priceElement.textContent = formattedPrice + '€';

                    const wishlistButton = document.createElement('button')

                    wishlistButton.setAttribute('type', 'button')
                    wishlistButton.classList.add('wishlist-button')
                    wishlistButton.id = item.itemId

                    const iconWishlistButton = document.createElement('i')

                    if (await inWishlist(item.itemId)) {
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

                    linkElement.appendChild(imageElement);
                    linkElement.appendChild(titleElement);
                    linkElement.appendChild(priceElement);

                    itemElement.appendChild(linkElement);
                    itemElement.append(wishlistButton)
                    itemsContainer.appendChild(itemElement);
                });

                paginationContainer.innerHTML = "";
                let numPages = Math.ceil(response.totalCount / limit);
                
                if (pageNumber > 3) {
                    
                    const button = document.createElement('button');
                        button.setAttribute('class', 'pagination-button');
                        button.setAttribute('id', 'previous-button');
                        button.innerHTML = '&#8592;';
                        paginationContainer.appendChild(button);

                    for (let i = 1; i <= Math.min(2, numPages - pageNumber + 1); i++) {
                        const button = document.createElement('button');
                        button.setAttribute('class', 'pagination-button');
                        button.setAttribute('id', 'pagination-button');

                        if (pageNumber % 2 === 0 && i === 2) {
                            button.textContent = pageNumber + 1;
                        }
                        else if (pageNumber % 2 !== 0 && i === 1) {
                            button.textContent = pageNumber - 1;
                        }
                        else {
                            button.textContent = pageNumber;
                        }
                        
                        paginationContainer.appendChild(button);
                    }

                    if (numPages - pageNumber >= 2) {
                        const button = document.createElement('button');
                        button.setAttribute('class', 'pagination-button');
                        button.setAttribute('id', 'next-button');
                        button.innerHTML = '&#8594;';
                        paginationContainer.appendChild(button);
                    }
                }
                else {
                    for (let i = 1; i <= Math.min(3, numPages); i++) {
                        const button = document.createElement('button');
                        button.setAttribute('class', 'pagination-button');
                        button.setAttribute('id', 'pagination-button');
                        button.textContent = i;
                        paginationContainer.appendChild(button);
                    }
                    if (numPages > 3) {
                        const button = document.createElement('button');
                        button.setAttribute('class', 'pagination-button');
                        button.setAttribute('id', 'next-button');
                        button.innerHTML = '&#8594;';
                        paginationContainer.appendChild(button);
                    }
                }
            

            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        } else {
            console.error('HTTP Error:', xhr.status);
        }
    };

    xhr.onerror = function() {
        console.error('Request failed');
    };

    xhr.send();
}

async function inWishlist(itemId) {
    try {
        const response = await fetch(`../api/api_is_in_wishlist.php?itemId=${itemId}`, {
            method: 'GET',
        });

        if (response.ok) {
            const data = await response.json();
            return data
        } else {
            console.error('Failed to check wishlist status for item with ID:', itemId);
            return false;
        }
    }
    catch (error) {
        console.error('Error checking if item is in wishlist!', error);
        return false;
    }
}
