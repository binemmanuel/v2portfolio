import { Ajax } from "./ajax.js";

window.onload = () => {
    console.log('Page loaded');
    
    // const search_bar = document.querySelector('#search-bar')

    // search_bar.addEventListener('keyup', (event) => {
    //     let keyword = search_bar.value
    
    //     const ajax = Ajax(
    //         'post',
    //         '<?= WEB_ROOT ?>/admin/users/search',
    //         '#search-result',
    //         `keyword=${keyword}&async=true`
    //     )
    // })

    // fetch('<?= WEB_ROOT ?>/admin/users/search')
    // .then(response => {
    //     console.log(response)
    // })
    // .then(data => console.log(data))
}