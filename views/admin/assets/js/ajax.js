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
const Ajax = (
    method,
    server,
    element,
    url = null
) => {
    let request = new XMLHttpRequest

    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.querySelector(element).innerHTML = this.responseText
        }
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


    /* if (method === 'POST') {
        request.open(method, server, true)
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
        request.send(url)

    } else {
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
    } */
}