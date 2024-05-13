const messages = document.getElementById("messages")
const contacts = document.getElementById("contacts")
const otherUser = document.getElementById("otherUser")

let copy

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

otherUser.addEventListener('change', function () {
    needMoreMessages = true
})

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

    const lastDate = document.getElementById("lastDate")

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
            firstTimestamp.setAttribute('id', 'lastDate');
            firstTimestamp.classList.add('messageDate');
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
                timestamp.classList.add('messageDate')
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
            time.classList.add('messageTime')
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
            limitContacts += 6
            offsetContacts += 6
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
        let currentYear = currentDate.getFullYear();
        let currentMonth = currentDate.getMonth() + 1;
        let currentDay = currentDate.getDate();
        let formattedCurrentDate = `${currentYear}-${currentMonth.toString().padStart(2, '0')}-${currentDay.toString().padStart(2, '0')}`;

        let date = new Date(finalResponse.contacts[i].timestamp)
        let year = date.getFullYear()
        let month = date.getMonth() + 1;

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
        image.classList.add('little')
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

//ver a query again
//METER PREPEND EM TUDO
//ARRANJAR MANEIRA DE NAO TAR SEMPRE A CARREGAR NOVOS CONTACTOS
//ARRANJAR MANEIRA DO SCROLL CHECK FUNCIONAR
//ARRANJAR MANEIRA DE MANTER A POSIÇAO DE SCROLL DA PAGINA SEMPRE QUE MENSAGENS SAO CARREGADAS
