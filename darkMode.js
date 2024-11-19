// check OS Dark Mode
function checkDarkMode(){
    if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        document.documentElement.setAttribute("color-theme", "dark");
    } else {
        document.documentElement.setAttribute("color-theme", "light");
    }
}

checkDarkMode();