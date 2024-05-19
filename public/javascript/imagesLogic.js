const sideImages = document.querySelectorAll('.side-image');

if(sideImages) {
    sideImages.forEach(sideImage => {
        sideImage.addEventListener('click', async function() {
            const mainImage = document.getElementById('main-image');
            const tempSrc = mainImage.src
            mainImage.src = this.src;
            this.src = tempSrc;
        })
    })
}