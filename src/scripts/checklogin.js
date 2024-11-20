document.addEventListener("DOMContentLoaded", () => {
    // html references
    const form = document.querySelector("form");
    const unInput = document.getElementById("username");
    const pwInput = document.getElementById("password");
    const submitButton = form.querySelector('input[type="submit"]');
    
    // untouched
    let touchUN = false;
    let touchPW = false;

    // validation
    function checkUsername(username) {
        const trimUsername = username.replace(/\s+/g, ""); 
        const hasMinLength = trimUsername.length >= 5;
        const hasUpperCase = /[A-Z]/.test(trimUsername);
        const hasLowerCase = /[a-z]/.test(trimUsername);
        return hasMinLength && hasUpperCase && hasLowerCase;
    }

    function checkPassword(password) {
        return password.length >= 10;
    }

    // color if interacted and green/red depending on situation
    function color(field, isValid, touched) {
        if (touched) {
            if (isValid) {
                field.style.border = "2px solid green";
            } else {
                field.style.border = "2px solid red";
            }
        } 
    }

    // enable or disable depending of situation
    function updateSubmitButtonState() {
        const usernameIsValid = checkUsername(unInput.value);
        const passwordIsValid = checkPassword(pwInput.value);

        color(unInput, usernameIsValid, touchUN);
        color(pwInput, passwordIsValid, touchPW);

        // disable button
        submitButton.disabled = !usernameIsValid || !passwordIsValid;
    }

    // real time check
    unInput.addEventListener("input", () => {
        touchUN = true; // mark field as touched on first input
        updateSubmitButtonState();
    });

    pwInput.addEventListener("input", () => {
        touchPW = true; // mark field as touched on first input
        updateSubmitButtonState();
    });

    // initial button state check
    updateSubmitButtonState();

    // prevent form submission if validation fails
    form.addEventListener("submit", (event) => {
        const usernameIsValid = checkUsername(unInput.value);
        const passwordIsValid = checkPassword(pwInput.value);
        
        if (!usernameIsValid || !passwordIsValid) {
            event.preventDefault();
        } else {
            alert("Login successfull");
        }
    });
});
