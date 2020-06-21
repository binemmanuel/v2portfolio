const $ = (selector, parent) => {
    return document.querySelector(selector)
}
const $$ = (selector) => {
    return document.querySelectorAll(selector)
}

const alert_box = $('.alert')

if (alert_box !== null) {
    setTimeout(() => {
        alert_box.style.opacity = 0
        alert_box.style.display = 'none'
    }, 6000)
}

function copy_url(web_root, url) {
    url = document.querySelector(url)
    web_root = encodeURI(web_root)

    let tmp_element = document.createElement('input')
    tmp_element.classList.add('hidden-url')
    tmp_element.style.position = 'absolute'
    tmp_element.style.top = '-1000%'
    tmp_element.setAttribute('value', web_root + url.value)
    body.append(tmp_element)
    

    tmp_element.select();
    tmp_element.focus()
    document.execCommand('SelectAll`')
    document.execCommand('Copy', false, null)
    
    let clipboard = document.createElement('div')
    clipboard.className = 'clipboard'
    let text = document.createElement('p')
    text.style.fontSize = '2rem'
    text.innerText = 'Copied to Clipboard.'
    clipboard.append(text)
    body.append(clipboard)

    clipboard.style.transform = 'translateX(200%)'
    clipboard.style.transition = 'transform .95s ease-in-out'
    
    setTimeout(() => {
        clipboard.style.transform = 'translateX(0)'
    }, 20)


    setTimeout(() => {
        clipboard.style.transform = 'translateX(200%)'
    }, 2400)

    setTimeout(() => {
        clipboard.parentNode.removeChild(clipboard)
        tmp_element.parentNode.removeChild(tmp_element)
    }, 3000)
}

function delete_media_modal(
    media_id,
    link_id,
    form
) {
    body.classList.add('show-delete-modal')
    body.classList.remove('show-edit-modal')

    let modal_input_id = form.querySelector('#object_id')
    let modal_input_link = form.querySelector('#object_link')
    modal_input_id.value = document.querySelector(media_id).value
    modal_input_link.value = document.querySelector(link_id).value
}

function edit_media_modal(
    media_id,
    link_id,
    form,
    media_details
) {
    body.classList.add('show-edit-modal')

    // let display = document.querySelector('#display')
    let modal_input_id = form.querySelector('#edit_object_id')
    let modal_hidden_input_link = form.querySelector('#edit_object_link')
    modal_input_id.value = document.querySelector(media_id).value
    modal_hidden_input_link.value = document.querySelector(link_id).value

    let display_container = document.querySelector('.edit-modal-file')

    if (display_container.innerHTML !== '') {
        display_container.innerHTML = ''
    }

    media_details.type = media_details.type.split('/')
    media_details.type = media_details.type[0]

    switch (media_details.type) {
        case 'image':
            display = document.createElement('img')
            display.setAttribute('src', media_details.web_root + modal_hidden_input_link.value)
            
            break;

        case 'video':
            display = document.createElement('video')
            display.setAttribute('src', media_details.web_root + modal_hidden_input_link.value)
            display.setAttribute('controls', '')

            break;
    }
    display_container.append(display)
    
    let modal_input_name = form.querySelector('#name')
    let modal_input_alt_text = form.querySelector('#alt_text')
    let modal_input_description = form.querySelector('#description')
    let modal_input_uploaded_by = form.querySelector('#author')
    let modal_input_link = form.querySelector('#link')
    
    modal_input_name.value = media_details.name
    modal_input_alt_text.value = media_details.alt_text
    modal_input_description.value = media_details.description
    modal_input_uploaded_by.value = media_details.uploaded_by
    modal_input_link.value = media_details.web_root + modal_hidden_input_link.value
    console.log(media_details.uploaded_by);
}

const menu_toggler = $('.menu-toggle')
const body = $('body')

menu_toggler.addEventListener('click', (event) => {
    body.classList.toggle('show-menu')   
})

let side_nav_item = $$('.side-nav-item')
let side_nav_links = $$('.side-nav-item span')

let page = window.location.href
url_page = page.split('/')

side_nav_item.forEach(side_nav_item =>{
    const page_title = side_nav_item.querySelector('span').innerText
    
    let $page;

    if (
        url_page[url_page.length - 2] !== '' &&
        url_page[url_page.length - 2] === 'library'
    ) {
        $page = url_page[url_page.length - 2]
    } else if (url_page[url_page.length - 1] !== '') {
        $page = url_page[url_page.length - 1]
    }
    
    switch ($page) {
        case 'admin':
            url_page[url_page.length - 1] = 'dashboard'

            break;

        case 'library':
            url_page[url_page.length - 1] = 'media'
            url_page[url_page.length - 2] = 'media'
            
            break;
    }

    if (
        url_page[url_page.length - 1] == page_title.toLowerCase() ||
        url_page[url_page.length - 2] == page_title.toLowerCase()
    ) {
        side_nav_item.classList.add('active')        
    } else {
        side_nav_item.classList.remove('active')
    }
})

let close_btns = $$('.close-btn')
if (close_btns !== null) {
    close_btns.forEach(close_btn => {
        close_btn.addEventListener('click', (event) => {
            event.preventDefault();
            
            let modal = $('#modal')
            
            modal.style.display = 'none'
            body.classList.remove('show-uploader')
            body.classList.remove('show-delete-modal')
            body.classList.remove('show-edit-modal')

            let display_container = document.querySelector('.edit-modal-file')
            if (display_container !== null) {
                display_container.innerHTML = ''
            }
        })
    }, false);
}

/* Check All */
let check_all = document.querySelectorAll('.checkall')

check_all.forEach(checkbox => {
    checkbox.addEventListener('click', () => {
        let all_check_boxs = document.querySelectorAll('.select')
        
        all_check_boxs.forEach(all_check_box => {
            console.log(all_check_box);
            
            if (all_check_box.getAttribute('checked') === null) {
                all_check_box.setAttribute('checked', '')
            } else {
                all_check_box.removeAttribute('checked')
            }
        });
        check_all.forEach(checkbox => {
            if (checkbox.getAttribute('checked') === null) {
                checkbox.setAttribute('checked', '')
            } else {
                checkbox.removeAttribute('checked')
            }
            
        })
    })
});


async function search(
    url,
    data = {}
) {
    const response = await fetch(url, {
        method: 'POST',
        catch: 'no-catch',
        credentials: 'same-origin',
        header: {
            'Content-Type': 'application/json',

        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: JSON.stringify(data)
    })

    return response.json()
}  

// search('<?= WEB_ROOT ?>admin/users/search', {
//     answer: 200
// })
// .then(data => console.log(data))


if(performance.navigation.type == 2)
{
    // Send your request here
}

console.log('Started...');