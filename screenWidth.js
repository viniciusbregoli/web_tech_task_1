// references from html file
const pContainer = document.getElementById("product-container");

function checkIsVertical() {
    if(window.innerWidth < window.innerHeight) {
        return true
    } else {
        return false
    }
}

function changeArrangement() {
    if(checkIsVertical()) {
        pContainer.style.flexDirection = 'column'
    } else {
        pContainer.style.flexDirection = 'row'
    }
}

// check the size when the screen first loads
changeArrangement()

// detect changes in screen size
window.addEventListener("resize", () => {
    changeArrangement()
})
