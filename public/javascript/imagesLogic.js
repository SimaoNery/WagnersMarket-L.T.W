const sideImages = document.querySelectorAll('.sideImage');

if(sideImages) {
    sideImages.forEach(sideImage => {
        sideImage.addEventListener('click', async function() {
            const mainImage = document.getElementById('mainImage');
            const tempSrc = mainImage.src
            mainImage.src = this.src;
            this.src = tempSrc;
        })
    })
}