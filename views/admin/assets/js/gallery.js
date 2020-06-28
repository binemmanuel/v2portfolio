const $ = (selector) => {
    return document.querySelector(selector)
}
const $$ = (selector) => {
    return document.querySelectorAll(selector)
}

const menu_toggler = $('.menu-toggle')
const nav_links = $$('.nav-link')
const body = $('body')

menu_toggler.addEventListener('click', (event) => {
    body.classList.toggle('show-menu')
})
nav_links.forEach(nav_link => {
    nav_link.addEventListener('click', (event) => {
        body.classList.remove('show-menu')
    })
});

console.log(body.clientWidth);

if (body.clientWidth >= 900) {
    setTimeout(() => {
        $('.social-menu').style.transform = `translateX(0)`
    }, 2000)
}



const cookie_note = $('.cookie-note')
const btn_close = $('.btn-close')
btn_close.addEventListener('click', () => {
    cookie_note.style.transform = 'translateY(100%)'
})

