
function navigateIfLoggedIn(isLoggedIn) {
    if (!isLoggedIn) {
        event.preventDefault();
        showLoginPopUp()
    }
}

function showLoginPopUp() {
    var popup = document.getElementById("popup-wrapper");
        if (popup) {
            popup.style.display = "block";
        }
}

function closeLoginPopUp() {
    var popup = document.getElementById("popup-wrapper");
        if (popup) {
            popup.style.display = "none";
        }
}