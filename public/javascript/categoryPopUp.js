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
    let popup = document.getElementById("add-category-popup")
        if (popup) {
            popup.style.display = "grid"
        }
}

function closeCategoryPopUp() {
    let popup = document.getElementById("add-category-popup")
        if (popup) {
            popup.style.display = "none"
        }
}

let changeCategoryImageButtons = document.querySelectorAll("[id^=change-category-image-popup-]")

if (changeCategoryImageButtons) {
    changeCategoryImageButtons.forEach(button => {
        button.addEventListener('click', function() {
            let categoryId = this.getAttribute('data-category-id')
            togglePopup(button, categoryId)
        })
    })
}

function togglePopup(button, categoryId) {
    let popup = document.getElementById("change-category-img-popup-" + categoryId)
    if (popup) {
        popup.classList.toggle("active")
        if (popup.classList.contains("active")) {
            button.textContent = "Cancel"
        } else {
            button.textContent = "Change the image"
        }
    }
}

