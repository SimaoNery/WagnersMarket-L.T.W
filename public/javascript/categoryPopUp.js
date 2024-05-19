let addCategoryButton = document.querySelector(".add-category-button")
let closeCategory = document.querySelector("#close-add-category-popup")

if (addCategoryButton) {
    addCategoryButton.addEventListener('click', function() {
        showCategoryPopUp()
    })
}

if (closeCategory) {
    closeCategory.addEventListener('click', function() {
        closeCategoryPopUp()
    })
}

function showCategoryPopUp() {
    let popup = document.getElementById("add-category-popup");
        if (popup) {
            popup.style.display = "grid";
        }
}

function closeCategoryPopUp() {
    let popup = document.getElementById("add-category-popup");
        if (popup) {
            popup.style.display = "none";
        }
}