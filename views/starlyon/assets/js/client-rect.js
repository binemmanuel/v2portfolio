class ClientRect {
    constructor(element) {
        this.element = document.querySelectorAll(element)
        console.log(this.element);
        
    }

    isInViewport = function (element){
        let bounding = element.getBoundingClientRect()
        return (
            (
                bounding.top - 15 <= 0
            ) &&
            (
                (bounding.bottom + 15) >= (window.innerHeight - 15)
            )
        )
    }
}