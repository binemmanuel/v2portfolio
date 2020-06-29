import { Loader } from "./Loader.js";

let btn = document.querySelector('.btn')
let body = document.querySelector('body')

btn.addEventListener('click', () => {
    const loader = new Loader

    loader.display('body')

    setTimeout(() => {
        loader.stop('body')
    }, 2000);
    
})

// let menu = ['test', 'play']
// console.log(menu.includes('play'));
 

