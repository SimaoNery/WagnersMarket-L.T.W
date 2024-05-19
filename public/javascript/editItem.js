


const changeImagesButton = document.querySelector('.change-images')


if (changeImagesButton) {
    changeImagesButton.addEventListener('click', async function() {
        const itemId = document.querySelector('.item-page').id
        const form = document.createElement('form');
        form.setAttribute('action', '../actions/action_change_item_images.php');
        form.setAttribute('method', 'post');
        form.setAttribute('id', 'image-form');
        form.setAttribute('enctype', 'multipart/form-data');

        const itemIdInput = document.createElement('input');
        itemIdInput.setAttribute('type', 'hidden');
        itemIdInput.setAttribute('name', 'itemId');
        itemIdInput.setAttribute('value', itemId);


        const inputFieldRequired = document.createElement('input');
        inputFieldRequired.setAttribute('type', 'file');
        inputFieldRequired.setAttribute('name', 'images[]');
        inputFieldRequired.setAttribute('required', '');
        inputFieldRequired.setAttribute('accept', "image/png,image/jpeg");

        form.appendChild(itemIdInput)
        form.appendChild(csrf)
        form.appendChild(inputFieldRequired)

        for (let i = 0; i < 7; i++) {
            const inputFieldNotRequired = document.createElement('input');
            inputFieldNotRequired.setAttribute('type', 'file');
            inputFieldNotRequired.setAttribute('name', 'images[]');
            inputFieldNotRequired.setAttribute('accept', "image/png,image/jpeg");

            form.appendChild(inputFieldNotRequired);
        }

        const saveButton = document.createElement('button');
        saveButton.textContent = "Save";
        form.appendChild(saveButton);
        form.appendChild(saveButton);

        const cancelButton = document.createElement('button');
        cancelButton.classList.add('cancel-change-image-button')
        const cancelIcon = document.createElement('i');
        cancelIcon.classList.add('fas', 'fa-times');
        cancelButton.appendChild(cancelIcon);

        changeImagesButton.parentNode.appendChild(form);
        changeImagesButton.parentNode.replaceChild(cancelButton, changeImagesButton);

        const cancelChangeImageButton = document.querySelector(".cancel-change-image-button")

        if (cancelChangeImageButton) {
            cancelChangeImageButton.addEventListener('click', async function() {
                const imageForm = document.querySelector('#image-form')
                if (imageForm) imageForm.remove()
                cancelChangeImageButton.parentNode.replaceChild(changeImagesButton, cancelChangeImageButton)
            })
        }

    })

}

const changeBrandButton = document.querySelector('.change-brand')


if (changeBrandButton) {
    changeBrandButton.addEventListener('click', async function() {

        const form = document.createElement('form');
        form.setAttribute('action', '../actions/action_change_brand.php');
        form.setAttribute('method', 'post');
        form.setAttribute('id', 'brand-form');

        const itemId = document.querySelector('.item-page').id
        const itemIdInput = document.createElement('input');
        itemIdInput.setAttribute('type', 'hidden');
        itemIdInput.setAttribute('name', 'itemId');
        itemIdInput.setAttribute('value', itemId);

        const brandInput = document.createElement('input');
        brandInput.setAttribute('type', 'text');
        brandInput.setAttribute('name', 'brand');
        brandInput.setAttribute('placeholder', 'Enter new brand');
        brandInput.setAttribute('required', '');


        form.appendChild(csrf)
        form.appendChild(itemIdInput)
        form.appendChild(brandInput);

        const saveButton = document.createElement('button');
        saveButton.textContent = "Save";
        form.appendChild(saveButton);

        const brandName = document.querySelector('#brand-name');
        if (brandName) {
            brandName.parentNode.replaceChild(form, brandName);
        }
        const initialBrandText = brandName.textContent;

        const cancelButton = document.createElement('button');
        cancelButton.setAttribute('id', 'cancel-brand-button');
        const cancelIcon = document.createElement('i');
        cancelIcon.classList.add('fas', 'fa-times');
        cancelButton.appendChild(cancelIcon);

        changeBrandButton.parentNode.replaceChild(cancelButton, changeBrandButton);


        const cancelChangeBrandButton = document.querySelector("#cancel-brand-button")
        if (cancelChangeBrandButton) {
            cancelChangeBrandButton.addEventListener('click', async function() {
                form.parentNode.replaceChild(brandName, form)
                if(brandName) brandName.innerHTML = initialBrandText;
                cancelChangeBrandButton.parentNode.replaceChild(changeBrandButton, cancelChangeBrandButton)
            })
        }
    })
}

const changeTitleButton = document.querySelector('.change-title')


if (changeTitleButton) {
    changeTitleButton.addEventListener('click', async function() {

        const form = document.createElement('form');
        form.setAttribute('action', '../actions/action_change_title.php');
        form.setAttribute('method', 'post');
        form.setAttribute('id', 'title-form');

        const itemId = document.querySelector('.item-page').id
        const itemIdInput = document.createElement('input');
        itemIdInput.setAttribute('type', 'hidden');
        itemIdInput.setAttribute('name', 'itemId');
        itemIdInput.setAttribute('value', itemId);

        const titleInput = document.createElement('input');
        titleInput.setAttribute('type', 'text');
        titleInput.setAttribute('name', 'title');
        titleInput.setAttribute('placeholder', 'Enter new title');
        titleInput.setAttribute('required', '');


        form.appendChild(csrf)
        form.appendChild(itemIdInput)
        form.appendChild(titleInput);

        const saveButton = document.createElement('button');
        saveButton.textContent = "Save";
        form.appendChild(saveButton);

        const titleName = document.querySelector('#title-name');
        if (titleName) {
            titleName.parentNode.replaceChild(form, titleName);
        }
        const initialTitleText = titleName.textContent;

        const cancelButton = document.createElement('button');
        cancelButton.setAttribute('id', 'cancel-title-button');
        const cancelIcon = document.createElement('i');
        cancelIcon.classList.add('fas', 'fa-times');
        cancelButton.appendChild(cancelIcon);

        changeTitleButton.parentNode.replaceChild(cancelButton, changeTitleButton);


        const cancelChangeTitleButton = document.querySelector("#cancel-title-button")
        if (cancelChangeTitleButton) {
            cancelChangeTitleButton.addEventListener('click', async function() {
                form.parentNode.replaceChild(titleName, form)
                if(cancelChangeTitleButton) titleName.innerHTML = initialTitleText;
                cancelChangeTitleButton.parentNode.replaceChild(changeTitleButton, cancelChangeTitleButton)
            })
        }
    })
}

const changeDescriptionButton = document.querySelector('.change-description')


if (changeDescriptionButton) {
    changeDescriptionButton.addEventListener('click', async function() {

        const form = document.createElement('form');
        form.setAttribute('action', '../actions/action_change_description.php');
        form.setAttribute('method', 'post');
        form.setAttribute('id', 'description-form');

        const itemId = document.querySelector('.item-page').id
        const itemIdInput = document.createElement('input');
        itemIdInput.setAttribute('type', 'hidden');
        itemIdInput.setAttribute('name', 'itemId');
        itemIdInput.setAttribute('value', itemId);

        const descriptionInput = document.createElement('textarea');
        descriptionInput.setAttribute('name', 'description');
        descriptionInput.setAttribute('placeholder', 'Enter new description');
        descriptionInput.setAttribute('required', '');

        form.appendChild(csrf)
        form.appendChild(itemIdInput)
        form.appendChild(descriptionInput);


        const saveButton = document.createElement('button');
        saveButton.textContent = "Save";
        form.appendChild(saveButton);

        const descriptionName = document.querySelector('#description-name');
        if (descriptionName) {
            descriptionName.parentNode.replaceChild(form, descriptionName);
        }
        const initialDescriptionText = descriptionName.textContent;

        const cancelButton = document.createElement('button');
        cancelButton.setAttribute('id', 'cancel-description-button');
        const cancelIcon = document.createElement('i');
        cancelIcon.classList.add('fas', 'fa-times');
        cancelButton.appendChild(cancelIcon);

        changeDescriptionButton.parentNode.replaceChild(cancelButton, changeDescriptionButton);


        const cancelChangeDescriptionButton = document.querySelector("#cancel-description-button")
        if (cancelChangeDescriptionButton) {
            cancelChangeDescriptionButton.addEventListener('click', async function() {
                form.parentNode.replaceChild(descriptionName, form)
                if(cancelChangeDescriptionButton) descriptionName.innerHTML = initialDescriptionText;
                cancelChangeDescriptionButton.parentNode.replaceChild(changeDescriptionButton, cancelChangeDescriptionButton)
            })
        }
    })
}





const deleteItemButton = document.querySelector('.delete-item')
if (deleteItemButton) {
    deleteItemButton.addEventListener('click', async function() {
        const itemId = document.querySelector('.item-page').id

        await fetch('../actions/action_delete_item.php', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: encodeForAjax({itemId: itemId, csrf: csrf.value}),

        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.success, true)
                    window.location.replace('index.php');
                } else {
                    showMessage(data.error, false)
                }
            })
            .catch(error => {
                console.error('Error:', error)
            })
    })
}








