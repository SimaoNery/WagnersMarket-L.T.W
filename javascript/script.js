const searchItem = document.querySelector('#searchitem')
const categories = document.querySelectorAll('#category input[type="checkbox"]')
const conditions = document.querySelectorAll('#condition input[type="checkbox"]')
const minInput = document.querySelector('#min-input')
const maxInput = document.querySelector('#max-input')
const minRange = document.querySelector('#min-range')
const maxRange = document.querySelector('#max-range')
const orderSelected = document.querySelector('#orderSelected')



let selectedCategories = []
let selectedConditions = []
let searchedItem = ''
//categoria, condition. search também pode ser feito por item_description
//size é do package, então não importa

//n da para filtrar por size ou brand
if (categories) {
    categories.forEach(category => {
        category.addEventListener('change', async function() {
            const categoryId = this.id;
            if (this.checked) {

                if (!selectedCategories.includes(categoryId)) {
                    selectedCategories.push(categoryId)
                }
            } else {
                selectedCategories = selectedCategories.filter(catId => catId !== categoryId)
            }
            await getSearchResults();
        })
    })
}

if (conditions) {
    conditions.forEach(condition => {
        condition.addEventListener('change', async function() {
            const conditionId = this.id;
            if (this.checked) {
                if (!selectedConditions.includes(conditionId)) {
                    selectedConditions.push(conditionId);
                }
            } else {
                selectedConditions = selectedConditions.filter(cId => cId !== conditionId);
            }
            await getSearchResults();
        })
    })
}

if (searchItem) {
    searchItem.addEventListener('input', async function() {
        searchedItem = this.value
        await getSearchResults();
    })
}

if (minInput) {
    minInput.addEventListener('change', async function() {
        minRange.value = this.value;
        if (parseInt(maxInput.value) < parseInt(this.value)) {
            maxInput.value = this.value;
            maxRange.value = this.value;
        }
        await getSearchResults();
    });
}

if (minRange) {
    minRange.addEventListener('change', async function() {
        minInput.value = this.value;
        if (parseInt(maxInput.value) < parseInt(this.value)) {
            maxInput.value = this.value;
            maxRange.value = this.value;
        }
        await getSearchResults();
    });
}

if (maxInput) {
    maxInput.addEventListener('change', async function() {
        maxRange.value = this.value;
        if (parseInt(minInput.value) > parseInt(this.value)) {
            minInput.value = this.value;
            minRange.value = this.value;
        }
        await getSearchResults();
    });
}

if (maxRange) {
    maxRange.addEventListener('change', async function() {
        maxInput.value = this.value;
        if (parseInt(minInput.value) > parseInt(this.value)) {
            minInput.value = this.value;
            minRange.value = this.value;
        }
        await getSearchResults();
    });
}

if(orderSelected) {
    orderSelected.addEventListener('change', async function () {
        await getSearchResults();
    });
}


async function getSearchResults() {

    let url = '../api/api_items.php?'
    let cat = selectedCategories.join(';');
    let cond = selectedConditions.join(';');
    let params = {search: searchedItem, category: cat, condition: cond, min: minInput.value, max: maxInput.value, order: orderSelected.value};
    url += new URLSearchParams(params).toString()

    const response = await fetch(url)

    let items = await response.json()

    const itemsSection = document.querySelector('#items')

    itemsSection.innerHTML = ''

    if (!items.length) {
        const paragraph = document.createElement('p')
        paragraph.id = 'not-found'
        paragraph.textContent = 'No items found'
        itemsSection.appendChild(paragraph)
    }

    for (const item of items) {
        const article = document.createElement('article')
        const img = document.createElement('img')
        const link = document.createElement('a')
        img.src = '/' + item.imagePath
        img.style = "width: 100px; height: 100px;"
        link.href = '../pages/item.php?id=' + item.itemId
        link.textContent = item.title
        article.appendChild(link)
        article.appendChild(img)
        itemsSection.appendChild(article)
    }
}



