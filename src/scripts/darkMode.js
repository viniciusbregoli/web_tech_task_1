// Change the mode of the site
function updateDarkMode(darkMode) {
    const baseImgPath = document.getElementById("dark-mode").getAttribute("data-img-path")
    
    localStorage.setItem("darkMode", darkMode.toString());
    document.documentElement.setAttribute("color-theme", darkMode ? "dark" : "light");
    document.getElementById("dark-mode").src = baseImgPath + (darkMode ? "sun.png" : "moon.png");
}

// Initial mode setting of the page
function setDarkMode() {
    var darkMode = localStorage.getItem("darkMode");

    // If the value is not in localStorage, set it according to the OS's default settings
    if(darkMode === null) {
        darkMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? 'true' : 'false';
    }

    updateDarkMode(darkMode === 'true')
}

// When the user clicks the Dark Mode button
function switchDarkMode() {
    const darkMode = localStorage.getItem("darkMode") === 'true';
    updateDarkMode(!darkMode)
}

setDarkMode();
document.getElementById("dark-mode").addEventListener("click", switchDarkMode)