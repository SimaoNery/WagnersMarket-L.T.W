const messages = document.getElementById("messages")
const contacts = document.getElementById("contacts")
const otherUser = document.getElementById("other-user")

let needMoreMessages = true
let limitMessages = 20
let offsetMessages = 0

let limitContacts = 20
let offsetContacts = 0

if (messages) {
    document.addEventListener("DOMContentLoaded", function() {
        messages.scrollTop = messages.scrollHeight
    })
}
if (otherUser) {
    otherUser.addEventListener('change', function () {
        needMoreMessages = true
    })
}


if (messages) {
    messages.addEventListener("scroll", async function() {
        if (messages.scrollTop === 0 && otherUser) {
            limitMessages += 20
            offsetMessages += 20
            await getMoreMessages();
        }
    })
}


async function getMoreMessages() {
    let need = false

    const lastDate = document.getElementById("last-date")

    const currentScrollHeight = messages.scrollHeight
    const currentScrollTop = messages.scrollTop


    let url = '../api/api_messages.php?'
    let params = {otherUser: otherUser.value, limit: limitMessages, offset: offsetMessages};
    url += new URLSearchParams(params).toString()

    const response = await fetch(url)
    const msgs = await response.json()

    if (msgs.length) {
        msgs.reverse()
        let date = new Date(msgs[msgs.length - 1].timestamp.toString())
        let year = date.getFullYear();
        let month = date.getMonth() + 1;
        let day = date.getDate();
        let current_date = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

        let newElements = document.createDocumentFragment();


        if(lastDate.innerHTML !== current_date) {
            newElements.innerHtml = messages.innerHTML
            messages.innerHTML = ''
            const firstTimestamp = document.createElement('time');
            firstTimestamp.innerHTML = current_date
            firstTimestamp.setAttribute('id', 'last-date');
            firstTimestamp.classList.add('message-date');
            lastDate.removeAttribute('id')
            messages.append(firstTimestamp)
        }
        else {
            messages.removeChild(lastDate)
            newElements.innerHtml = messages.innerHTML
            messages.innerHTML = ''
            copy = lastDate
            need = true
        }

        for (const msg of msgs) {
            let date = new Date(msg.timestamp)


            let year = date.getFullYear()
            let month = date.getMonth() + 1;
            let day = date.getDate()
            let hour = date.getHours()
            let minute = date.getMinutes()

            let paddedHour = hour < 10 ? '0' + hour : hour;
            let paddedMinute = minute < 10 ? '0' + minute : minute;
            let formattedDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`
            let formattedTime = paddedHour + ':' + paddedMinute;


            if (formattedDate !== current_date) {
                need = false;
                const timestamp = document.createElement('time');
                timestamp.innerHTML = formattedDate
                timestamp.classList.add('message-date')
                messages.append(timestamp)
                current_date = formattedDate
            }

            const message = document.createElement('section');
            const content = document.createElement('p');

            const leftOrRight = msg.receiverId.toString() === otherUser.value ? "right" : "left"
            message.classList.add('message')
            message.classList.add(leftOrRight);

            content.innerHTML = msg.content
            message.append(content)

            const time = document.createElement('time');
            time.classList.add('message-time')
            time.dateTime = msg.timestamp
            time.innerHTML = formattedTime

            message.append(time)
            messages.append(message)
        }

        if (need && copy) {
            messages.prepend(copy)
            need = false
        }
        messages.innerHTML += newElements.innerHtml
        messages.scrollTop = currentScrollTop + (messages.scrollHeight - currentScrollHeight);
    }
    else needMoreMessages = false;

}


if (contacts) {

    contacts.addEventListener("scroll", async function() {
        if (contacts.scrollHeight - contacts.scrollTop <= contacts.clientHeight+ 20) {
            limitContacts += 20
            offsetContacts += 20
            await getMoreContacts();
        }
    })
}


async function getMoreContacts() {
    let url = '../api/api_contacts.php?'
    let params = {limit: limitContacts, offset: offsetContacts}
    url += new URLSearchParams(params).toString()

    const response = await fetch(url)
    const finalResponse = await response.json()


    for (let i = 0; i < finalResponse.contacts.length; i++) {
        let currentDate = new Date();
        let currentYear = currentDate.getFullYear()
        let currentMonth = currentDate.getMonth() + 1
        let currentDay = currentDate.getDate()
        let formattedCurrentDate = `${currentYear}-${currentMonth.toString().padStart(2, '0')}-${currentDay.toString().padStart(2, '0')}`;

        let date = new Date(finalResponse.contacts[i].timestamp)
        let year = date.getFullYear()
        let month = date.getMonth() + 1

        let day = date.getDate()
        let hour = date.getHours()
        let minute = date.getMinutes()

        let paddedHour = hour < 10 ? '0' + hour : hour;
        let paddedMinute = minute < 10 ? '0' + minute : minute;
        let formattedDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`
        let formattedTime = paddedHour + ':' + paddedMinute;

        const link = document.createElement('a')
        const username = document.createElement('span')
        const contact = document.createElement('section')
        const image = document.createElement('img')
        const time = document.createElement('time')
        const content = document.createElement('p')

        link.href = "../../public/pages/messages.php?otherUserId=" + finalResponse.otherIds[i]
        content.innerHTML = finalResponse.contacts[i].content
        username.innerHTML = finalResponse.usernames[i]
        image.src = finalResponse.profilePics[i]
        contact.classList.add('contact')
        time.dateTime = contact.timestamp
        time.innerHTML = formattedDate !== formattedCurrentDate ? formattedDate : formattedTime


        contact.append(username)
        contact.append(image)
        contact.append(content)
        contact.append(time)
        link.append(contact)
        contacts.append(link)
    }
}


const form = document.querySelector("#send-message");

if (form) {
    form.addEventListener('submit', async function(event) {
        event.preventDefault()
        const otherUserId = document.getElementById('other-user').value
        const message = document.querySelector("#content")

        if (message) {
            await sendMessage(otherUserId, message.value)
            message.value = ""
        }

    })

}

async function sendMessage(otherUserId, message) {
    if(document.querySelector('#no-messages-sent')) messages.innerHTML = ''
    if(document.querySelector('#no-open-conversations')) contacts.innerHTML = ''
    const allTimeElements = document.querySelectorAll('#messages > time');
    let lastTimeElement = allTimeElements.length ? allTimeElements[allTimeElements.length - 1].innerHTML : false;

    const params = new URLSearchParams()
    params.append('other-user-id', otherUserId.toString())
    params.append('message', message.toString())

    const request = new XMLHttpRequest()
    request.open('POST', '../actions/action_send_message_2.php', true)
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onload = function () {
        try {
            const messageTime = JSON.parse(request.responseText)
            const msg = document.createElement('section')
            const content = document.createElement('p')

            msg.classList.add('message')
            msg.classList.add('right');

            content.innerHTML = message
            msg.append(content)

            let date = new Date(messageTime)

            let year = date.getFullYear()
            let month = date.getMonth() + 1

            let day = date.getDate()
            let hour = date.getHours()
            let minute = date.getMinutes()

            let paddedHour = hour < 10 ? '0' + hour : hour;
            let paddedMinute = minute < 10 ? '0' + minute : minute;
            let formattedDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`
            let formattedTime = paddedHour + ':' + paddedMinute;


            if (lastTimeElement) {
                let currentDate = new Date(lastTimeElement)
                let currentYear = currentDate.getFullYear()
                let currentMonth = currentDate.getMonth() + 1
                let currentDay = currentDate.getDate()
                let formattedCurrentDate = `${currentYear}-${currentMonth.toString().padStart(2, '0')}-${currentDay.toString().padStart(2, '0')}`

                if (formattedDate !== formattedCurrentDate) {
                    const dateOfMessage = document.createElement('time')
                    dateOfMessage.classList.add('message-date')
                    dateOfMessage.dateTime = formattedDate
                    dateOfMessage.innerHTML = formattedTime
                    messages.append(dateOfMessage)
                }
            } else {
                const dateOfMessage = document.createElement('time')
                dateOfMessage.classList.add('message-date')
                dateOfMessage.dateTime = formattedDate
                dateOfMessage.innerHTML = formattedDate
                messages.append(dateOfMessage)
            }

            const time = document.createElement('time')
            time.classList.add('message-time')
            time.dateTime = messageTime
            time.innerHTML = formattedTime


            msg.append(time)
            messages.append(msg)

            const username = document.querySelector('#conversation-header h3').innerHTML
            const img = document.querySelector('#conversation-header img').cloneNode(true);
            const contactArray = contacts.querySelectorAll('#contacts a')

            const newContact = document.createElement('a')
            newContact.href = "../../public/pages/messages.php?otherUserId=" + otherUserId.toString()
            const contactSection = document.createElement('section')
            contactSection.classList.add('contact')

            const span = document.createElement('span')
            span.innerHTML = username

            const par_msg = document.createElement('p')
            par_msg.textContent = message

            const contactTime = document.createElement('time')
            contactTime.dateTime = messageTime
            contactTime.innerHTML = formattedTime

            contactSection.append(span)
            contactSection.append(par_msg)
            contactSection.append(img)
            contactSection.append(contactTime)
            newContact.append(contactSection)

            if (contactArray && username) {

                contactArray.forEach(contact => {
                    const sp = contact.querySelector("span");
                    if (sp && sp.innerHTML === username) {
                        contact.remove()
                    }
                })
            }

            contacts.prepend(newContact)

            messages.scrollTop = messages.scrollHeight
        } catch (error) {
            console.error('Error parsing JSON:', error);
        }
    }
    request.send(params.toString());

}

if (contacts) {
    const contactLinks = contacts.querySelectorAll('a')
    if (contactLinks) {

        contactLinks.forEach(contactLink => {

            contactLink.addEventListener('click', async function(event) {

                event.preventDefault();
                limitMessages = 20
                offsetMessages = 0
                await changeMessagesContainer(contactLink);
            })
        })
    }
}




async function changeMessagesContainer(contactLink) {
    const oldImage = document.querySelector('#conversation_header img')
    const oldUsername = document.querySelector('#conversation_header h3')
    const newImg = contactLink.querySelector('img')
    const newUsername = contactLink.querySelector('span')

    oldImage.src = newImg.src
    oldUsername.innerHTML = newUsername.innerHTML

    let url = '../api/api_messages.php?'
    let params = {otherUser: contactLink.id, limit: limitMessages, offset: offsetMessages};
    url += new URLSearchParams(params).toString()

    const response = await fetch(url)
    const msgs = await response.json()

    messages.innerHTML = ''




    if (msgs.length) {
        let date = new Date(msgs[0].timestamp.toString())
        let year = date.getFullYear();
        let month = date.getMonth() + 1;
        let day = date.getDate();
        let current_date = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

        const initialTimestamp = document.createElement('time');
        initialTimestamp.innerHTML = current_date
        initialTimestamp.classList.add('messageDate')
        initialTimestamp.timestamp = msgs[0].timestamp.toString()
        initialTimestamp.id = 'lastDate'
        messages.append(initialTimestamp)


        for (const msg of msgs) {
            let date = new Date(msg.timestamp)


            let year = date.getFullYear()
            let month = date.getMonth() + 1;
            let day = date.getDate()
            let hour = date.getHours()
            let minute = date.getMinutes()

            let paddedHour = hour < 10 ? '0' + hour : hour;
            let paddedMinute = minute < 10 ? '0' + minute : minute;
            let formattedDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`
            let formattedTime = paddedHour + ':' + paddedMinute;


            if (formattedDate !== current_date) {
                const timestamp = document.createElement('time');
                timestamp.innerHTML = formattedDate
                timestamp.classList.add('messageDate')
                messages.append(timestamp)
                current_date = formattedDate
            }

            const message = document.createElement('section');
            const content = document.createElement('p');

            const leftOrRight = msg.receiverId.toString() === contactLink.id ? "right" : "left"
            message.classList.add('message')
            message.classList.add(leftOrRight);

            content.innerHTML = msg.content
            message.append(content)

            const time = document.createElement('time');
            time.classList.add('messageTime')
            time.dateTime = msg.timestamp
            time.innerHTML = formattedTime

            message.append(time)
            messages.append(message)
            messages.scrollTop = messages.scrollHeight
        }
    }

}


// METER PREPEND EM TUDO

