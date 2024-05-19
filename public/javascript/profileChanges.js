document.addEventListener('DOMContentLoaded', function() {
    const nameSpan = document.querySelector('#name-span');
    const emailSpan = document.querySelector('#email-span');

    if (emailSpan) {
        const initialEmailText = emailSpan.textContent;
        setupEmailEditButton(initialEmailText);
    }

    if (nameSpan) {
        const initialNameText = nameSpan.textContent;
        setupNameEditButton(initialNameText);
    }

    setupImageEditButton();
});

function setupEmailCancelButton(initialEmailText) {
    const emailCancel = document.querySelector('#cancel-email-button');
    const emailForm = document.querySelector('#email-form');

    if (emailCancel && emailForm) {
        emailCancel.addEventListener('click', function(event) {
            const span = document.createElement('span');
            span.setAttribute('id', 'email-span');
            span.textContent = initialEmailText;

            emailForm.parentNode.replaceChild(span, emailForm);

            const newButton = document.createElement('button');
            newButton.setAttribute('id', 'edit-email-button');
            const newIcon = document.createElement('i');
            newIcon.classList.add('fas', 'fa-pencil-alt');
            newButton.appendChild(newIcon);

            emailCancel.parentNode.replaceChild(newButton, emailCancel);
            setupEmailEditButton(initialEmailText);
        });
    } else {
        console.log('emailCancel or emailForm is null or undefined');
    }
}

function setupEmailEditButton(initialEmailText) {
    const emailChange = document.querySelector('#edit-email-button');

    if (emailChange) {
        emailChange.addEventListener('click', function(event) {
            const form = document.createElement('form');
            form.setAttribute('action', '../actions/action_change_costumer_email.php');
            form.setAttribute('method', 'post');
            form.setAttribute('id', 'email-form');

            const emailInput = document.createElement('input');
            emailInput.setAttribute('type', 'email');
            emailInput.setAttribute('name', 'email');
            emailInput.setAttribute('placeholder', 'Enter new email');
            emailInput.setAttribute('required', '');

            form.appendChild(emailInput);

            const saveButton = document.createElement('button');
            saveButton.textContent = "Save";
            form.appendChild(saveButton);

            const emailSpan = document.querySelector('#email-span');
            if (emailSpan) {
                emailSpan.parentNode.replaceChild(form, emailSpan);
            }

            const cancelButton = document.createElement('button');
            cancelButton.setAttribute('id', 'cancel-email-button');
            const cancelIcon = document.createElement('i');
            cancelIcon.classList.add('fas', 'fa-times');
            cancelButton.appendChild(cancelIcon);

            emailChange.parentNode.replaceChild(cancelButton, emailChange);
            setupEmailCancelButton(initialEmailText);
        });
    }
}

function setupNameCancelButton(initialNameText) {
    const nameCancel = document.querySelector('#cancel-name-button');
    const nameForm = document.querySelector('#name-form');

    if (nameCancel && nameForm) {
        nameCancel.addEventListener('click', function(event) {
            const span = document.createElement('span');
            span.setAttribute('id', 'name-span');
            span.textContent = initialNameText;

            nameForm.parentNode.replaceChild(span, nameForm);

            const newButton = document.createElement('button');
            newButton.setAttribute('id', 'edit-name-button');
            const newIcon = document.createElement('i');
            newIcon.classList.add('fas', 'fa-pencil-alt');
            newButton.appendChild(newIcon);

            nameCancel.parentNode.replaceChild(newButton, nameCancel);
            setupNameEditButton(initialNameText);
        });
    } else {
        console.log('nameCancel or nameForm is null or undefined');
    }
}

function setupNameEditButton(initialNameText) {
    const nameChange = document.querySelector('#edit-name-button');

    if (nameChange) {
        nameChange.addEventListener('click', function(event) {
            const form = document.createElement('form');
            form.setAttribute('action', '../actions/action_change_costumer_name.php');
            form.setAttribute('method', 'post');
            form.setAttribute('id', 'name-form');

            const nameInput = document.createElement('input');
            nameInput.setAttribute('type', 'text');
            nameInput.setAttribute('name', 'name');
            nameInput.setAttribute('placeholder', 'Enter new name');
            nameInput.setAttribute('required', '');

            form.appendChild(nameInput);

            const saveButton = document.createElement('button');
            saveButton.textContent = "Save";
            form.appendChild(saveButton);

            const nameSpan = document.querySelector('#name-span');
            if (nameSpan) {
                nameSpan.parentNode.replaceChild(form, nameSpan);
            }

            const cancelButton = document.createElement('button');
            cancelButton.setAttribute('id', 'cancel-name-button');
            const cancelIcon = document.createElement('i');
            cancelIcon.classList.add('fas', 'fa-times');
            cancelButton.appendChild(cancelIcon);

            nameChange.parentNode.replaceChild(cancelButton, nameChange);
            setupNameCancelButton(initialNameText);
        });
    }
}

function setupImageEditButton() {
    const imageChange = document.querySelector('#edit-image-button');

    if (imageChange) {
        imageChange.addEventListener('click', function(event) {
            const form = document.createElement('form');
            form.setAttribute('action', '../actions/action_change_profile_pic.php');
            form.setAttribute('method', 'post');
            form.setAttribute('id', 'image-form');
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
            cancelButton.setAttribute('id', 'cancel-image-button');
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
    const imageCancel = document.querySelector('#cancel-image-button');
    const imageForm = document.querySelector('#image-form');

    if (imageCancel && imageForm) {
        imageCancel.addEventListener('click', function(event) {
            imageForm.remove();

            const newButton = document.createElement('button');
            newButton.setAttribute('id', 'edit-image-button');
            const newIcon = document.createElement('i');
            newIcon.classList.add('fas', 'fa-pencil-alt');
            newButton.appendChild(newIcon);

            imageCancel.parentNode.replaceChild(newButton, imageCancel);
            setupImageEditButton();
        });
    }
}
