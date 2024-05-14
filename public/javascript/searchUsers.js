const searchUsers = document.querySelector("#searchUsers")
const userBoxes = document.querySelector("#users")

let input = ""
let limitSearchUsers = 6
let offsetSearchUsers = 0


if (searchUsers) {
    searchUsers.addEventListener('input', async function() {
        limitSearchUsers = 6
        offsetSearchUsers = 0
        input = this.value
        await drawUsers();
    })
}

if (userBoxes) {
    userBoxes.addEventListener("scroll", async function() {
        if (userBoxes.scrollHeight - userBoxes.scrollTop <= userBoxes.clientHeight ) {
            console.log('coise')
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
                            const userInfo = document.createElement('userInfo')
                            const userManagement = document.createElement('userManagement')
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
                            profileLink.classList.add('profileLink')
                            profilePic.src= user.profilePic
                            userId.innerHTML = `User ID: ${user.userId}`
                            userId.classList.add("userId")
                            name.innerHTML = `Name: ${user.name}`
                            name.classList.add("name")
                            username.innerHTML = `Username: ${user.username}`
                            username.classList.add("username")
                            email.innerHTML = `Email: ${user.email}`
                            email.classList.add("email")

                            manageAdminStatus.innerHTML = user.admin ? 'Revoke Admin Privileges' : 'Grant Admin Privileges'
                            manageAdminStatus.classList.add('manageAdminStatus')
                            manageAdminStatus.setAttribute('adminStatus', user.admin ? 'RevokeAdmin' : 'GrantAdmin')
                            manageAdminStatus.setAttribute('userId', user.userId)
                            banUser.innerHTML = 'Ban User'
                            banUser.classList.add('banUser')
                            deleteAccount.innerHTML = 'Delete Account'
                            deleteAccount.classList.add('deleteAccount')
                            deleteAccount.setAttribute('userId', user.userId)

                            userInfo.classList.add('userInfo')
                            userManagement.classList.add('userManagement')

                            userInfo.append(userId)
                            userInfo.append(name)
                            userInfo.append(username)
                            userInfo.append(email)

                            userManagement.append(profileLink)
                            userManagement.append(manageAdminStatus)
                            userManagement.append(banUser)
                            userManagement.append(deleteAccount)

                            profileLinkOnImage.append(profilePic)
                            profileLinkOnImage.classList.add('profileLinkOnImage')
                            userSection.classList.add('userBox')
                            userSection.append(profileLinkOnImage)
                            userSection.append(userInfo)
                            userSection.append(userManagement)

                            users.append(userSection)

                            const adminStatusButtons = document.querySelectorAll(".manageAdminStatus")
                            if (adminStatusButtons) {
                                adminStatusButtons.forEach(adminStatusButton => {
                                    adminStatusButton.addEventListener('click', async function() {
                                        const userId = this.getAttribute('userId')
                                        const isAdmin = this.getAttribute('adminStatus') === 'RevokeAdmin'
                                        await changeAdminStatus(userId, isAdmin, adminStatusButton)
                                    })
                                })
                            }

                            const deleteAccountButtons = document.querySelectorAll(".deleteAccount")
                            if (deleteAccountButtons) {
                                deleteAccountButtons.forEach(deleteAccountButton => {
                                    deleteAccountButton.addEventListener('click', async function() {
                                        const userId = this.getAttribute('userId')
                                        await deleteUserAccount(userId, userSection)
                                    })
                                })
                            }

                            const banUserButtons = document.querySelectorAll(".banUser")
                            if (banUserButtons) {
                                banUserButtons.forEach(banUserButton => {
                                    banUserButton.addEventListener('click', async function() {
                                        const userId = this.getAttribute('userId')
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
    params.append('userId', userId.toString())
    params.append('isAdmin', isAdmin.toString())

    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_change_admin_status.php', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')

    request.onload = function () {
        try {
            const changeWentWell = JSON.parse(request.responseText)

            if (Boolean(changeWentWell)) {
                if (!isAdmin) {
                    adminStatusButton.innerHTML = 'Revoke Admin Privileges'
                    adminStatusButton.setAttribute('adminStatus', 'RevokeAdmin')
                }
                else {
                    adminStatusButton.innerHTML = 'Grant Admin Privileges'
                    adminStatusButton.setAttribute('adminStatus', 'GrantAdmin')
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
    params.append('userId', userId.toString())

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


