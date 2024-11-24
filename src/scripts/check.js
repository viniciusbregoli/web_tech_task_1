document.addEventListener("DOMContentLoaded", () => {
    //html references
    const form = document.querySelector("form");
    const unInput = document.getElementById("username");
    const pwInput = document.getElementById("password");
    const confirmPwInput = document.getElementById("confirm_password");
    const submitButton = form.querySelector('input[type="submit"]');

    // helper for validation (text)
    const unMessage = document.createElement("span");
    const pwMessage = document.createElement("span");
    const confirmPwMessage = document.createElement("span");

    // font styling
    const messageStyle = "color: red; font-size: 12px; display: block; margin-top: 5px;";
    unMessage.style.cssText = messageStyle;
    pwMessage.style.cssText = messageStyle;
    confirmPwMessage.style.cssText = messageStyle;

    unInput.insertAdjacentElement("afterend", unMessage);
    pwInput.insertAdjacentElement("afterend", pwMessage);
    confirmPwInput && confirmPwInput.insertAdjacentElement("afterend", confirmPwMessage);

    //checks if the field has been interacted
    let touchUN = false;
    let touchPW = false;
    let touchConfirmPW = false;

    //validation things
    function checkUsername(username) {
        const trimUsername = username.replace(/\s+/g, ""); 
        const hasMinLength = trimUsername.length >= 5;
        const hasUpperCase = /[A-Z]/.test(trimUsername);
        const hasLowerCase = /[a-z]/.test(trimUsername);

        if (touchUN) {
            if (!hasMinLength) {
                unMessage.textContent = "Username must be at least 5 characters long.";
            } else if (!hasUpperCase || !hasLowerCase) {
                unMessage.textContent = "Username must contain uppercase and lowercase letters.";
            } else {
                unMessage.textContent = "";
            }
        }

        return hasMinLength && hasUpperCase && hasLowerCase;
    }

    function checkPassword(password) {
        const isValid = password.length >= 10;
        if (touchPW) {
            if (isValid){
                pwMessage.textContent="";
            }
            else{
                pwMessage.textContent="Password must be at least 10 characters long.";
            }
        }
        return isValid;
    }

    function checkPasswordMatch(password, confirmPassword) {
        const isValid = password === confirmPassword;
        if (touchConfirmPW) {
            confirmPwMessage.textContent = isValid ? "" : "Passwords do not match.";
        }
        return isValid;
    }

    function color(field, isValid) {
        if (isValid) {
            field.style.border = "2px solid green";
        } else {
            field.style.border = "2px solid red";
        }
    }

    // submit button things
    function updateSubmitButtonState() {
        const usernameIsValid = unInput ? checkUsername(unInput.value) : true;
        const passwordIsValid = pwInput ? checkPassword(pwInput.value) : true;
        const passwordsMatch = confirmPwInput ? checkPasswordMatch(pwInput.value, confirmPwInput.value) : true;

        // button gets disabled if someth is wrong
        submitButton.disabled = !usernameIsValid || !passwordIsValid || !passwordsMatch;
    }

    // real time check for username
    unInput.addEventListener("input", () => {
        touchUN = true;
        const isValid = checkUsername(unInput.value);
        color(unInput, isValid);
        updateSubmitButtonState();
    });

    // real time check for passw

    pwInput.addEventListener("input", () => {
            touchPW = true;
            const isValid = checkPassword(pwInput.value);
            color(pwInput, isValid);

            if (confirmPwInput) {
                const passwordsMatch = checkPasswordMatch(pwInput.value, confirmPwInput.value);
                color(confirmPwInput, isValid && passwordsMatch);
            }
            updateSubmitButtonState();
        });
    

    //real time check for pasword conf

    confirmPwInput.addEventListener("input", () => {
            touchConfirmPW = true;
            const isValid = checkPassword(pwInput.value);
            const passwordsMatch = checkPasswordMatch(pwInput.value, confirmPwInput.value);

            color(confirmPwInput, isValid && passwordsMatch);
            updateSubmitButtonState();
        });
    

    // initial button state check
    updateSubmitButtonState();

    // prevent form submission if validation fails
    form.addEventListener("submit", (event) => {
        const usernameIsValid = checkUsername(unInput.value);
        const passwordIsValid = checkPassword(pwInput.value);
        const passwordsMatch = confirmPwInput ? checkPasswordMatch(pwInput.value, confirmPwInput.value) : true;

        if (!usernameIsValid || !passwordIsValid || !passwordsMatch) {
            event.preventDefault(); // stop the form from submitting if validation fails
        } else {
            alert("Registration successful!");
        }
    });
});
