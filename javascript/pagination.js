const paginationContainer = document.querySelector('#pagination');
let limit = 8;
let offset = 0;
paginationContainer.addEventListener('click', function(event) {
    if (event.target.tagName === 'BUTTON') {
        const buttonId = event.target.id;
        let pageNumber = 1;

        if (buttonId === 'pagination-button') {
            pageNumber = parseInt(event.target.textContent);
        } else if (buttonId === 'next-button') {
            console.log('Clicked on Next button');
            pageNumber += 1;
        }

        offset = (pageNumber - 1) * limit;

        fetchMostPopularItems(limit, offset);
    }
});

function changeItemsPerPage() {
    const selectElement = document.getElementById('itemsPerPage');
    limit = parseInt(selectElement.value);

    fetchMostPopularItems(limit, offset);
}

function fetchMostPopularItems(limit, offset) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../api/api_items.php?limit=${limit}&offset=${offset}`, true);

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            try {
                const response = JSON.parse(xhr.responseText);

                const mostPopularContainer = document.querySelector('#most-popular');
                mostPopularContainer.innerHTML = '';

                response.forEach(item => {
                    const itemElement = document.createElement('li');
                    itemElement.classList.add('item-card');

                    const linkElement = document.createElement('a');
                    linkElement.href = `../pages/item.php?id=${item.itemId}`;

                    const imageElement = document.createElement('img');
                    imageElement.src = item.imagePath;
                    imageElement.style.width = '100px';
                    imageElement.style.height = '100px';

                    const titleElement = document.createElement('h4');
                    titleElement.textContent = item.title;

                    const priceElement = document.createElement('p');
                    const formattedPrice = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(item.price);

                    priceElement.textContent = formattedPrice + '€';

                    linkElement.appendChild(imageElement);
                    linkElement.appendChild(titleElement);
                    linkElement.appendChild(priceElement);

                    itemElement.appendChild(linkElement);

                    mostPopularContainer.appendChild(itemElement);
                });
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