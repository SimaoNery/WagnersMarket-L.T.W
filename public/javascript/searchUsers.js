
async function showMessage(message, success) {
    const messageOccurredSection = document.getElementById('message-occurred');
    const messageParagraph = document.getElementById('message-text');

    if (messageOccurredSection && messageParagraph) {
        messageParagraph.innerHTML = message;
        messageOccurredSection.style.display = 'block';
        if (success) messageOccurredSection.style.backgroundColor = 'rgba(99,219,107,0.8)'
        else messageOccurredSection.style.backgroundColor = 'rgba(255, 0, 0, 0.8)'


        setTimeout(() => {
            messageOccurredSection.style.display = 'none';
            messageParagraph.textContent = '';
        }, 3000);
    }

}


const searchUsers = document.querySelector("#search-users")
const userBoxes = document.querySelector("#users")


let input = ""
let limitSearchUsers = 6
let offsetSearchUsers = 0


if (searchUsers) {
    searchUsers.addEventListener('input', async function() {
        limitSearchUsers = 6
        offsetSearchUsers = 0
        input = this.value.trim();
        if (input.length === 0) {
            users.innerHTML = "";
            return
        } 
        await drawUsers();
        
    })
}

if (userBoxes) {
    userBoxes.addEventListener("scroll", async function() {
        if (userBoxes.scrollHeight - userBoxes.scrollTop <= userBoxes.clientHeight ) {
            limitMessages += 6
            offsetMessages += 6
            await drawUsers();
        }

    })
}

async function drawUsers() {
    const request = new XMLHttpRequest();
    request.open('GET', `../api/api_search_users.php?search=${input}&limit=${limitSearchUsers}&offset=${offsetSearchUsers}`)
    request.onload = function() {
        if (request.status >= 200 && request.status < 400) {
            try {
                const response = JSON.parse(request.responseText);
                if (response) {
                    const users = document.getElementById("users")
                    users.innerHTML = ""

                    if (users) {
                        response.forEach(user => {
                            const profileLinkOnImage = document.createElement('a')
                            const profileLink = document.createElement('a')
                            const userSection = document.createElement('section')
                            const userInfo = document.createElement('user-info')
                            const userManagement = document.createElement('user-management')
                            const profilePic = document.createElement('img')
                            const userId = document.createElement('p')
                            const name = document.createElement('p')
                            const username = document.createElement('p')
                            const email = document.createElement('p')
                            const manageAdminStatus = document.createElement('button')
                            const banUser = document.createElement('button')
                            const deleteAccount = document.createElement('button')

                            profileLinkOnImage.href = `../../public/pages/profile.php?id=${user.userId}`
                            profileLink.href = `../../public/pages/profile.php?id=${user.userId}`
                            profileLink.innerHTML = 'Profile'
                            profileLink.classList.add('profile-link')
                            profileLink.classList.add('button')
                            profilePic.src= user.profilePic
                            userId.innerHTML = `User ID: ${user.userId}`
                            userId.classList.add("user-id")
                            name.innerHTML = `Name: ${user.name}`
                            name.classList.add("name")
                            username.innerHTML = `Username: ${user.username}`
                            username.classList.add("username")
                            email.innerHTML = `Email: ${user.email}`
                            email.classList.add("email")

                            manageAdminStatus.innerHTML = user.admin ? 'Revoke Admin Privileges' : 'Grant Admin Privileges'
                            manageAdminStatus.classList.add('manage-admin-status')
                            manageAdminStatus.setAttribute('admin-status', user.admin ? 'RevokeAdmin' : 'GrantAdmin')
                            manageAdminStatus.setAttribute('user-id', user.userId)
                            banUser.innerHTML = 'Ban User'
                            banUser.classList.add('ban-user')
                            banUser.classList.add('button')
                            deleteAccount.innerHTML = 'Delete Account'
                            deleteAccount.classList.add('delete-account')
                            deleteAccount.classList.add('button')
                            deleteAccount.setAttribute('user-id', user.userId)

                            userInfo.classList.add('user-info')
                            userManagement.classList.add('user-management')

                            userInfo.append(userId)
                            userInfo.append(name)
                            userInfo.append(username)
                            userInfo.append(email)

                            userManagement.append(profileLink)
                            userManagement.append(manageAdminStatus)
                            userManagement.append(banUser)
                            userManagement.append(deleteAccount)

                            profileLinkOnImage.append(profilePic)
                            profileLinkOnImage.classList.add('profile-link-on-image')
                            userSection.classList.add('user-box')
                            userSection.append(profileLinkOnImage)
                            userSection.append(userInfo)
                            userSection.append(userManagement)

                            users.append(userSection)

                            const adminStatusButtons = document.querySelectorAll(".manage-admin-status")
                            if (adminStatusButtons) {
                                adminStatusButtons.forEach(adminStatusButton => {
                                    adminStatusButton.addEventListener('click', async function() {
                                        const userId = this.getAttribute('user-id')
                                        const isAdmin = this.getAttribute('admin-status') === 'RevokeAdmin'
                                        await changeAdminStatus(userId, isAdmin, adminStatusButton)
                                    })
                                })
                            }

                            const deleteAccountButtons = document.querySelectorAll(".delete-account")
                            if (deleteAccountButtons) {
                                deleteAccountButtons.forEach(deleteAccountButton => {
                                    deleteAccountButton.addEventListener('click', async function() {
                                        const userId = this.getAttribute('user-id')
                                        await deleteUserAccount(userId, userSection)
                                    })
                                })
                            }

                            const banUserButtons = document.querySelectorAll(".ban-user")
                            if (banUserButtons) {
                                banUserButtons.forEach(banUserButton => {
                                    banUserButton.addEventListener('click', async function() {
                                        const userId = this.getAttribute('user-id')
                                        // await banUserAccount(userId, userSection)
                                    })
                                })
                            }

                        })
                    }
                }

            } catch (error) {
                console.error('Error parsing JSON:', error);
            }
        } else {
            console.error('HTTP Error:', request.status);
        }
    }

    request.onerror = function() {
        console.error('Request failed');
    }

    request.send();
}




async function changeAdminStatus(userId, isAdmin, adminStatusButton) {

    const params = new URLSearchParams()
    params.append('user-id', userId.toString())
    params.append('is-admin', isAdmin.toString())

    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_change_admin_status.php', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    request.onload = function () {
        try {
            const changeWentWell = JSON.parse(request.responseText)

            if (Boolean(changeWentWell)) {
                if (!isAdmin) {
                    adminStatusButton.innerHTML = 'Revoke Admin Privileges'
                    adminStatusButton.setAttribute('admin-status', 'RevokeAdmin')
                }
                else {
                    adminStatusButton.innerHTML = 'Grant Admin Privileges'
                    adminStatusButton.setAttribute('admin-status', 'GrantAdmin')
                }
            }

        } catch (error) {
            console.error('Error parsing JSON:', error);
        }
    }
    request.send(params.toString());
}


async function deleteUserAccount(userId, userSection) {

    const params = new URLSearchParams()
    params.append('user-id', userId.toString())

    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_delete_account.php', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    request.onload = function () {
        try {
            const deletionWentWell = JSON.parse(request.responseText)
            if (deletionWentWell) userSection.remove();

        } catch (error) {
            console.error('Error parsing JSON:', error);
        }
    }
    request.send(params.toString());
}



const formsRemoveCategory = document.querySelectorAll(".remove-category");

if (formsRemoveCategory) {
    formsRemoveCategory.forEach(formRemoveCategory => {
        formRemoveCategory.addEventListener('submit', async function(event) {
            event.preventDefault()
            const categoryName = formRemoveCategory.querySelector(".category-name").value

            if (categoryName) {
                await removeCategory(categoryName, formRemoveCategory)
            }

        })
    })
}

async function removeCategory(categoryName, formRemoveCategory) {
    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_remove_category.php', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {
        const response = JSON.parse(request.responseText)
        if (response.success) {
            formRemoveCategory.parentNode.remove()
            showMessage(response.success, true);
        }
        else {
            showMessage(response.error, false);
        }

    }
    request.send(encodeForAjax({'category' : categoryName}))
}

const formAddCategory = document.querySelector(".add-new-category");

if (formAddCategory) {

    formAddCategory.addEventListener('submit', async function(event) {

        event.preventDefault()
        const categoryName = document.getElementById('category-name').value
        const fileInput = document.querySelector('.add-new-category input[type=file]')
        const file = fileInput.files[0];
        if (categoryName && file) {
            await addCategory(categoryName, file)
        }
    })
}

async function addCategory(categoryName, file) {

    const formData = new FormData();
    formData.append("category", categoryName)
    formData.append("image", file);

    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_add_category.php', true)
    request.onload = function () {
        try {

            const response = JSON.parse(request.responseText)


            if (response.success) {
                const category_item = document.createElement('li')
                category_item.classList.add('category-item')

                const category_link = document.createElement('a')
                category_link.href = "../../public/pages/search.php?category=" + categoryName

                const category_image = document.createElement('img')
                category_image.src = response.imagePath
                category_image.alt = categoryName

                const span = document.createElement('span')
                span.innerHTML = categoryName

                category_link.append(category_image)
                category_link.append(span)

                const formRemoveCategory = document.createElement('form')
                formRemoveCategory.action = "../actions/action_remove_category.php"
                formRemoveCategory.method = "post"
                formRemoveCategory.classList.add("remove-category")

                const inputCategoryName = document.createElement('input')
                inputCategoryName.type = 'hidden'
                inputCategoryName.classList.add("remove-category")
                inputCategoryName.value = categoryName
                inputCategoryName.name = 'category'

                const inputSubmit = document.createElement('input')
                inputSubmit.type = 'submit'
                inputSubmit.innerHTML = 'Remove Category'

                formRemoveCategory.append(inputCategoryName)
                formRemoveCategory.append(inputSubmit)

                const buttonChangeImage = document.createElement('button')
                buttonChangeImage.type = 'button'
                buttonChangeImage.innerHTML = 'Change the image'

                const formChangeImage = document.createElement('form')
                formChangeImage.action = "../actions/action_change_image_category.php"
                formChangeImage.method = "post"
                formChangeImage.classList.add("change-image-category")
                formChangeImage.enctype = "multipart/form-data"

                const inputCategoryNameChangeImage = document.createElement('input')
                inputCategoryNameChangeImage.type = 'hidden'
                inputCategoryNameChangeImage.value = categoryName
                inputCategoryNameChangeImage.name = 'category'

                const label = document.createElement('label')
                label.innerHTML = "Upload an image"

                const inputUploadFile = document.createElement('input')
                inputUploadFile.type = 'file'
                inputUploadFile.accept = "image/png,image/jpeg"
                inputUploadFile.name = 'image'
                inputUploadFile.required = true

                label.append(inputUploadFile)

                const inputSubmitChangeImage = document.createElement('input')
                inputSubmitChangeImage.type = 'submit'
                inputSubmitChangeImage.value = 'Change the category\'s image'

                formChangeImage.append(inputCategoryNameChangeImage)
                formChangeImage.append(label)
                formChangeImage.append(inputSubmitChangeImage)

                category_item.append(category_link)
                category_item.append(formRemoveCategory)
                category_item.append(formChangeImage)

                const ul = document.querySelector('.category-list')
                if (ul) ul.append(category_item)

                showMessage(response.success, true)
            }
            else {
                showMessage(response.error, false)
            }
        } catch (e) {
            console.error('Error parsing JSON:', e);
            console.error('Response text:', request.responseText);
        }


    }
    request.send(formData)
}

const formsChangeCategoryImage = document.querySelectorAll(".change-image-category");

if (formsChangeCategoryImage) {
    formsChangeCategoryImage.forEach(formChangeCategoryImage => {
        formChangeCategoryImage.addEventListener('submit', async function(event) {

            event.preventDefault()
            const categoryName = formChangeCategoryImage.querySelector('input[type=hidden]').value
            const fileInput = formChangeCategoryImage.querySelector('input[type=file]')
            const file = fileInput.files[0];
            const oldImage = formChangeCategoryImage.parentNode.querySelector('a img')
            if (categoryName && file && oldImage) {
                await changeImageCategory(categoryName, file, oldImage)
            }
        })
    })
}
async function changeImageCategory(categoryName, file, oldImage) {

    const formData = new FormData();
    formData.append("category", categoryName)
    formData.append("image", file);

    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_change_image_category.php', true)
    request.onload = function () {
        try {
            const response = JSON.parse(request.responseText)

            if (response.success) {

                oldImage.src = response.imagePath

                showMessage(response.success, true)

            }
            else {
                showMessage(response.error, false)
            }
        } catch (e) {
            console.error('Error parsing JSON:', e);
            console.error('Response text:', request.responseText);
        }


    }
    request.send(formData)
}

const formsRemoveSize = document.querySelectorAll(".remove-size");

if (formsRemoveSize) {
    formsRemoveSize.forEach(formRemoveSize => {
        formRemoveSize.addEventListener('submit', async function(event) {

            event.preventDefault()
            const size = formRemoveSize.querySelector('input[type=hidden]').value
            const sizeElement = formRemoveSize.parentNode
            if (size && sizeElement) {
                await removeSize(size, sizeElement)
            }
        })
    })
}

async function removeSize(size, sizeElement) {
    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_remove_size.php', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {
        const response = JSON.parse(request.responseText)
        if (response.success) {
            sizeElement.remove()
            showMessage(response.success, true);
        }
        else {
            showMessage(response.error, false);
        }

    }
    request.send(encodeForAjax({'size' : size}))
}

const formAddSize = document.getElementById("add-new-size");

if (formAddSize) {

    formAddSize.addEventListener('submit', async function(event) {

        event.preventDefault()
        const size = formAddSize.querySelector('#size-name')
        if (size) {
            await addSize(size.value)
            size.value = ''
        }
    })
}

async function addSize(size) {
    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_add_size.php', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {
        const response = JSON.parse(request.responseText)
        if (response.success) {
            const sizeList = document.getElementById('size-list')
            if (sizeList) {
                const li = document.createElement('li')
                li.classList.add('size-item')
                const span = document.createElement('span')
                span.innerHTML = size
                const form = document.createElement('form')
                form.classList.add('remove-size')
                form.action = "../actions/action_remove_size.php"
                form.method = 'post'


                const inputSizeName = document.createElement('input')
                inputSizeName.type = 'hidden'
                inputSizeName.name = 'size'
                inputSizeName.value = size
                const inputSubmit = document.createElement('input')
                inputSubmit.type = 'submit'
                inputSubmit.value = 'Remove Size'
                inputSubmit.classList.add('button')

                form.append(inputSizeName)
                form.append(inputSubmit)

                li.append(span)
                li.append(form)
                const referenceNode = sizeList.children[sizeList.children.length - 1]
                sizeList.insertBefore(li, referenceNode)
            }
            showMessage(response.success, true);
        }
        else {
            showMessage(response.error, false);
        }

    }
    request.send(encodeForAjax({'size' : size}))
}


const formAddCondition = document.getElementById("add-new-condition");

if (formAddCondition) {

    formAddCondition.addEventListener('submit', async function(event) {

        event.preventDefault()
        const condition = formAddCondition.querySelector('#condition-name')
        if (condition) {
            await addCondition(condition.value)
            condition.value = ''
        }
    })
}

async function addCondition(condition) {
    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_add_condition.php', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {
        const response = JSON.parse(request.responseText)
        if (response.success) {
            const conditionList = document.getElementById('condition-list')
            if (conditionList) {
                const li = document.createElement('li')
                li.classList.add('size-item')
                const span = document.createElement('span')
                span.innerHTML = condition
                const form = document.createElement('form')
                form.classList.add('remove-condition')
                form.action = "../actions/action_remove_condition.php"
                form.method = 'post'


                const inputConditionName = document.createElement('input')
                inputConditionName.type = 'hidden'
                inputConditionName.name = 'condition'
                inputConditionName.value = condition
                const inputSubmit = document.createElement('input')
                inputSubmit.type = 'submit'
                inputSubmit.value = 'Remove Condition'

                form.append(inputConditionName)
                form.append(inputSubmit)

                li.append(span)
                li.append(form)
                const referenceNode = conditionList.children[conditionList.children.length - 1]
                conditionList.insertBefore(li, referenceNode)
            }
            showMessage(response.success, true);
        }
        else {
            showMessage(response.error, false);
        }

    }
    request.send(encodeForAjax({'condition' : condition}))
}



const formsRemoveCondition = document.querySelectorAll(".remove-condition");

if (formsRemoveCondition) {
    formsRemoveCondition.forEach(formRemoveCondition => {
        formRemoveCondition.addEventListener('submit', async function(event) {

            event.preventDefault()
            const condition = formRemoveCondition.querySelector('input[type=hidden]').value
            const conditionElement = formRemoveCondition.parentNode
            if (condition && conditionElement) {
                await removeCondition(condition, conditionElement)
            }
        })
    })
}

async function removeCondition(condition, conditionElement) {
    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_remove_condition.php', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {
        const response = JSON.parse(request.responseText)
        if (response.success) {
            conditionElement.remove()
            showMessage(response.success, true);
        }
        else {
            showMessage(response.error, false);
        }

    }
    request.send(encodeForAjax({'condition' : condition}))
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}