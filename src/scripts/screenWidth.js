// Change page layout
function changeArrangement() {
    const pContainer = document.getElementById("product-container");
    pContainer.style.flexDirection = window.innerWidth < window.innerHeight ? 'column' : 'row' // Check screen orientation and Change direction
}

// Check the size when the screen first loads
changeArrangement()

// Detect changes in screen size
window.addEventListener("resize", changeArrangement)
