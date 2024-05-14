
document.addEventListener('DOMContentLoaded', function() {
    const emailSpan = document.querySelector('#emailSpan');
    if (emailSpan) {
        const initialEmailText = emailSpan.textContent;
        setupEmailEditButton(initialEmailText);
    }

    const nameSpan = document.querySelector('#nameSpan');
    if (nameSpan) {
        const initialNameText = nameSpan.textContent;
        setupNameEditButton(initialNameText);
    }

    setupImageEditButton();
});

function setupEmailCancelButton(initialEmailText) {
    const emailCancel = document.querySelector('#cancelEmailButton');
    const emailForm = document.querySelector('#emailForm');

    if (emailCancel) {
        emailCancel.addEventListener('click', function(event) {
            const span = document.createElement('span');
            span.setAttribute('id', 'emailSpan');
            span.textContent = initialEmailText;

            emailForm.parentNode.replaceChild(span, emailForm);

            const newButton = document.createElement('button');
            newButton.setAttribute('id', 'editEmailButton');
            const newIcon = document.createElement('i');
            newIcon.classList.add('fas', 'fa-pencil-alt');
            newButton.appendChild(newIcon);

            emailCancel.parentNode.replaceChild(newButton, emailCancel);
            setupEmailEditButton(initialEmailText);
            
        });
    } else {
        console.log('emailCancel is null or undefined');
    }
}

function setupEmailEditButton(initialEmailText) {
    const emailChange = document.querySelector('#editEmailButton');

    if (emailChange) {
        emailChange.addEventListener('click', function(event) {
            const form = document.createElement('form');
            form.setAttribute('action', '../actions/action_change_costumer_email.php');
            form.setAttribute('method', 'post');
            form.setAttribute('id', 'emailForm');

            const emailInput = document.createElement('input');
            emailInput.setAttribute('type', 'email');
            emailInput.setAttribute('name', 'email');
            emailInput.setAttribute('placeholder', 'Enter new email');
            emailInput.setAttribute('required', '');

            form.appendChild(emailInput);

            const saveButton = document.createElement('button');
            saveButton.textContent = "Save";

            form.appendChild(saveButton);

            emailSpan.parentNode.replaceChild(form, emailSpan);

            const cancelButton = document.createElement('button');
            cancelButton.setAttribute('id', 'cancelEmailButton');

            const cancelIcon = document.createElement('i');
            cancelIcon.classList.add('fas', 'fa-times');

            cancelButton.appendChild(cancelIcon);

            emailChange.parentNode.replaceChild(cancelButton, emailChange);
            setupEmailCancelButton(initialEmailText);
        });
    }
}


function setupNameCancelButton(initialNameText) {
    const nameCancel = document.querySelector('#cancelNameButton');
    const nameForm = document.querySelector('#nameForm');

    if (nameCancel) {
        nameCancel.addEventListener('click', function(event) {
            const span = document.createElement('span');
            span.setAttribute('id', 'nameSpan');
            span.textContent = initialNameText;

            nameForm.parentNode.replaceChild(span, nameForm);

            const newButton = document.createElement('button');
            newButton.setAttribute('id', 'editNameButton');
            const newIcon = document.createElement('i');
            newIcon.classList.add('fas', 'fa-pencil-alt');
            newButton.appendChild(newIcon);

            nameCancel.parentNode.replaceChild(newButton, nameCancel);
            setupNameEditButton(initialNameText);
            
        });
    } else {
        console.log('nameCancel is null or undefined');
    }
}

function setupNameEditButton(initialNameText) {
    const nameChange = document.querySelector('#editNameButton');

    if (nameChange) {
        nameChange.addEventListener('click', function(event) {
            const form = document.createElement('form');
            form.setAttribute('action', '../actions/action_change_costumer_name.php');
            form.setAttribute('method', 'post');
            form.setAttribute('id', 'nameForm');

            const nameInput = document.createElement('input');
            nameInput.setAttribute('type', 'text');
            nameInput.setAttribute('name', 'name');
            nameInput.setAttribute('placeholder', 'Enter new name');
            nameInput.setAttribute('required', '');

            form.appendChild(nameInput);

            const saveButton = document.createElement('button');
            saveButton.textContent = "Save";

            form.appendChild(saveButton);

            nameSpan.parentNode.replaceChild(form, nameSpan);

            const cancelButton = document.createElement('button');
            cancelButton.setAttribute('id', 'cancelNameButton');

            const cancelIcon = document.createElement('i');
            cancelIcon.classList.add('fas', 'fa-times');

            cancelButton.appendChild(cancelIcon);

            nameChange.parentNode.replaceChild(cancelButton, nameChange);
            setupNameCancelButton(initialNameText);
        });
    }
}

function setupImageEditButton() {
    const imageChange = document.querySelector('#editImageButton');

    if (imageChange) {
        imageChange.addEventListener('click', function(event) {

            const form = document.createElement('form');
            form.setAttribute('action', '../actions/action_change_profile_pic.php');
            form.setAttribute('method', 'post');
            form.setAttribute('id', 'imageForm');
            form.setAttribute('enctype', 'multipart/form-data');

            const inputField = document.createElement('input');
            inputField.setAttribute('type', 'file');
            inputField.setAttribute('name', 'image[]');
            inputField.setAttribute('required', '');
            inputField.setAttribute('accept', "image/png,image/jpeg");

            form.appendChild(inputField);

            const saveButton = document.createElement('button');
            saveButton.textContent = "Save";
            form.appendChild(saveButton);

            const cancelButton = document.createElement('button');
            cancelButton.setAttribute('id', 'cancelImageButton');

            const cancelIcon = document.createElement('i');
            cancelIcon.classList.add('fas', 'fa-times');

            cancelButton.appendChild(cancelIcon);

            imageChange.parentNode.appendChild(form);

            imageChange.parentNode.replaceChild(cancelButton, imageChange);
            setupImageCancelButton();
        });
    }
}

function setupImageCancelButton() {
    const imageCancel = document.querySelector('#cancelImageButton');
    const imageSpan = document.querySelector('#imageForm')

    if (imageCancel) {
        imageCancel.addEventListener('click', function(event) {
            imageSpan.remove();

            const newButton = document.createElement('button');
            newButton.setAttribute('id', 'editImageButton');
            const newIcon = document.createElement('i');
            newIcon.classList.add('fas', 'fa-pencil-alt');
            newButton.appendChild(newIcon);

            imageCancel.parentNode.replaceChild(newButton, imageCancel);
            setupImageEditButton();
        });
    }
}