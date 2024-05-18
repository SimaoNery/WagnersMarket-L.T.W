const notLoggedIn = document.querySelectorAll('.not-logged-in')

if (notLoggedIn) {
    notLoggedIn.forEach(notLoggedInElement => {
        notLoggedInElement.addEventListener('click', function() {
            showLoginPopUp();
        })
    })
}




function showLoginPopUp() {
    let popup = document.getElementById("popup-wrapper");
        if (popup) {
            popup.style.display = "block";
        }
}

function closeLoginPopUp() {
    let popup = document.getElementById("popup-wrapper");
        if (popup) {
            popup.style.display = "none";
        }
}

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('showLogin') && urlParams.get('showLogin') === 'true') {
        showLoginPopUp();
    }
});
