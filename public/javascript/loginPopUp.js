const notLoggedIn = document.querySelectorAll('.not-logged-in')

if (notLoggedIn) {
    notLoggedIn.forEach(notLoggedInElement => {
        notLoggedInElement.addEventListener('click', function() {
            showLoginPopUp();
        })
    })
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