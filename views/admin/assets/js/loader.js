class Loader {
    constructor() {
        // Create Loader container.
        this.loader_container = document.createElement('div')

        // Add the loader-container class.
        this.loader_container.classList.add('loader-container')

        // Create Loader container.
        this.loader = document.createElement('div')

        // Add the loader class.
        this.loader.classList.add('loader')
    }

    /**
     * Display the loader.
     */
    display = (element) => {
        // Get an element to add the loader to.
        this.parent_loader = document.querySelector(element)

        this.loader_container.append(this.loader)
        this.parent_loader.append(this.loader_container)
    }

    /**
     * Stop loader.
     */
    stop = () => {
        this.loader_container = document.querySelector('.loader-container');

        this.loader_container.parentNode.removeChild(this.loader_container)
    } 
}

/* 
<div class="loader-container">
    <div class="loader"></div>
</div>
*/