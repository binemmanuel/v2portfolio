/**
 * File main.js..
 *
 * The main script for StarLyon.
 */

const $ = (selector, parent) => {
    return document.querySelector(selector)
}
const $$ = (selector) => {
    return document.querySelectorAll(selector)
}

const alert = $('.alert')

if (alert !== null) {
    setTimeout(() => {
        alert.style.opacity = 0
        alert.style.visibility = 'hidden'
    }, 1000)
}

const menu_toggler = $('.menu-toggle')
const body = $('body')

menu_toggler.addEventListener('click', (event) => {
    body.classList.toggle('show-menu')
    
})

const nav_links = $$('.nav-link')

nav_links.forEach(nav_link => {
    nav_link.addEventListener('click', (event) => {
        body.classList.remove('show-menu')
    })
});

const back_to_top = $('.back-to-top')
const cookie_note = $('.cookie-note')
const btn_close = $('.cookie-note .btn-close')

btn_close.addEventListener('click', () => {
    cookie_note.style.display = 'none'
    console.log('Closed cookie note.');
    back_to_top.style.bottom = '4rem'
    
})

/* function initMap() {
    const location = {
        lat: 9.099210,
        lng: 7.408710
    }
    const map_container = $('.map')

    const map = new google.maps.Map(
        map_container,
        {
            zoom: 4,
            center: location
        }
    )

    let api_key = 'AIzaSyAe48UWjcCK8q8IEt6ScCP7EMX2zLjRl3k'
    
    let script_tag = document.createElement('script')
    script_tag.setAttribute('async', '')
    script_tag.setAttribute('defer', '')
    script_tag.setAttribute('src', `https://maps.googleapis.com/maps/api/js?key=${api_key}&callback=initMap`)

    map_container.append(script_tag)
} */

const client_rect = new ClientRect('[data-page]')
setInterval(
    () => {
        client_rect.element.forEach(element => {
            let inBound = client_rect.isInViewport(element)
            
            if (inBound) {
                let title = document.querySelector('title')
                
                nav_links.forEach(nav_link => {

                    let page = element.dataset.page
                    if (page[page.length - 1] === 's') {
                        page = page.substring(0, page.length - 1)
                    }

                    if (nav_link.innerText.toLowerCase() === page) {
                        nav_link.classList.add('active')
                        
                        let title_text = title.innerText.trim()
                        title_text = title_text.split('|')
                        title.innerText = `${nav_link.innerText} | ${title_text[title_text.length - 1].trim()}`
                        
                    } else {
                        nav_link.classList.remove('active')

                    }
                });
            }
        })
    },
    990
)


if(performance.navigation.type == 2)
{
    // Send your request here
}

console.log('Started...');