/**
 * Send an async request to a server.
 * 
 * @param String The method (POST or GET). 
 * @param String The server side application that should do the processing. 
 * @param String The element in which the data should be loaded to. 
 * @param String The data to be sent to the server.
 * 
 * @return Void
 */
export class Ajax extends XMLHttpRequest {
    constructor (
        method,
        server,
        element,
        url = null
    ) {
        super()

        this.method = method
        this.server = server
        this.element = element
        this.url = url

        this.onreadystatechange = function () {
            if (this.readyState < 4) {
                // let search_box = document.querySelector(element)
    
                // const loader_container = document.createElement('div')
                // const first_bounce = document.createElement('div')
                // const last_bounce = document.createElement('div')
    
                // loader_container.className = 'loader-container'
                // first_bounce.classList.add('bounce')
                // first_bounce.classList.add('first-bounce')
    
                // last_bounce.classList.add('bounce')
                // last_bounce.classList.add('last-bounce')
    
                // loader_container.append(first_bounce)
                // loader_container.append(last_bounce)
    
                // search_box.innerHTML = ''
                // search_box.append(loader_container)
    
                // const loader = new Loader
                // loader.display()
            }
    
            // if (this.readyState === 4 && this.status === 200) {
            //     document.querySelector(element).innerHTML = this.responseText
            // }
        }
        
        switch (this.method.toLowerCase()) {
            case 'post':
                this.open(
                    this.method,
                    this.server,
                    true
                )
    
                this.setRequestHeader(
                    'Content-type',
                    'application/x-www-form-urlencoded'
                )
    
                this.send(url)
    
    
                break;
        
            default:
                    // Create a URL if url is not empty.
                    if (url !== null) {
                        url = server + '?' + url
                    }
                    
                    this.open(
                        method,
                        url,
                        true
                    )
                    this.send()
                break;
        }
    }
    
}

/* const Ajax = (
    method,
    server,
    element,
    url = null
) => {
    let request = new XMLHttpRequest

    request.onreadystatechange = function () {
        if (this.readyState < 4) {
            // let search_box = document.querySelector(element)

            // const loader_container = document.createElement('div')
            // const first_bounce = document.createElement('div')
            // const last_bounce = document.createElement('div')

            // loader_container.className = 'loader-container'
            // first_bounce.classList.add('bounce')
            // first_bounce.classList.add('first-bounce')

            // last_bounce.classList.add('bounce')
            // last_bounce.classList.add('last-bounce')

            // loader_container.append(first_bounce)
            // loader_container.append(last_bounce)

            // search_box.innerHTML = ''
            // search_box.append(loader_container)

            const loader = new Loader
            loader.display()
        }

        // if (this.readyState === 4 && this.status === 200) {
        //     document.querySelector(element).innerHTML = this.responseText
        // }
    }
    
    switch (method.toLowerCase()) {
        case 'post':
            request.open(
                method,
                server,
                true
            )

            request.setRequestHeader(
                'Content-type',
                'application/x-www-form-urlencoded'
            )

            request.send(url)


            break;
    
        default:
                // Create a URL if url is not empty.
                if (url !== null) {
                    url = server + '?' + url
                }
                
                request.open(
                    method,
                    url,
                    true
                )
                request.send()
            break;
    }
} */