const sideImages = document.querySelectorAll('.sideImage');
const mainImage = document.getElementById('mainImage');

sideImages.forEach(function(image) {
    image.addEventListener('click', function() {
        //Get clicked image path and id
        const sideSRC = this.getAttribute('src');
        const sideID = this.getAttribute('id');

        //Set the main path and id, to the clicked image one's
        mainImage.setAttribute('src', sideSRC);
        mainImage.setAttribute('data-id', sideID);
    });
});