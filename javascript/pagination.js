const itemsPerPageSelect = document.getElementById('itemsPerPage');
const paginationButtons = document.querySelectorAll('.pagination-button');

if (itemsPerPageSelect) {
    itemsPerPageSelect.addEventListener('change', function() {
        const limit = parseInt(this.value);
        const offset = 0; 
        reload(limit, offset);
    });
}

if (paginationButtons) {
    paginationButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const limit = parseInt(itemsPerPageSelect.value);
            const offset = parseInt(this.dataset.offset);
            reload(limit, offset);
        });
    });
}

async function reload(limit, offset) {
    const response = await fetch('../api/api_item.php?limit=' + limit + '&offset=' + offset);
    const items = await response.json();

    const container = document.querySelector('most-popular');
    container.innerHTML = '';

    items.forEach(function(item) {
        const li = document.createElement('li');
        li.classList.add('item-card');

        const link = document.createElement('a');
        link.href = '../pages/item.php?id=' + item.itemId;

        const img = document.createElement('img');
        img.src = item.images.length > 0 ? item.images[0].path : ''; 
        img.style.width = '100px';
        img.style.height = '100px';

        const h4 = document.createElement('h4');
        h4.textContent = item.title;

        const p = document.createElement('p');
        p.textContent = Number(item.price).toFixed(2) + '€';

        link.appendChild(img);
        link.appendChild(h4);
        link.appendChild(p);

        li.appendChild(link);
        container.appendChild(li);
    });
}


