/**
 * File notifications.js..
 *
 * This script is responsibe for displaying notifications on the
 * StarLyon Theme.
 */
function make_element(name) {
    return document.createElement(name)
}

function display_notes(notes) {
    const notification_div = $('.notifications');
    const ul = make_element('ul')

    notes.forEach(note => {
        const li = make_element('li')
        const btn_contaner = make_element('div')
        const close_btn = make_element('i')
        const message = make_element('p')

        li.append(btn_contaner)
        li.append(message)
        btn_contaner.append(close_btn)
        message.innerText = note

        close_btn.classList.add('fa')
        close_btn.classList.add('fa-times')
        ul.append(li)
    });

    notification_div.appendChild(ul)
}

function delete_note(notification) {
    notifications.forEach(notification => {
        const notification_btn = notification.querySelector('div')
        notification_btn.addEventListener('click', () => {
            let note = notification.children[notification.children.length - 1].innerText
            let note_index = notes.indexOf(note)
    
            notes.splice(notes.indexOf(note_index), 1)
    
            // notifications.splice(notifications.indexOf(note_index), 1)
            notification.style.transform = 'translateX(120%)'
            notification.style.opacity = '0'
        })
    })
}

let notes = [
    'Are you a programmer that wants to work with me on a project? I love collaborate with others.',
    'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Corporis unde eius, deleniti consequatur accusamus error quasi sed? Expedita, quod fuga!',
    'Testing'
]

// display_notes(notes)
// const notifications = $$('.notifications li')
// delete_note(notifications)