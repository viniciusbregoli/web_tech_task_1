//dom load
document.addEventListener("DOMContentLoaded", () => {
    //references from html file
    const form = document.querySelector("form");
    const unInput = document.getElementById("username");
    const pwInput = document.getElementById("password");
    const confirmPwInput = document.getElementById("confirm_password"); 

    //function for un check
    function checkUsername(username) {
        const hasMinLength = username.length >= 5;
        const hasUpperCase = /[A-Z]/.test(username);
        const hasLowerCase = /[a-z]/.test(username);
        return hasMinLength && hasUpperCase && hasLowerCase;
    }

    //check password
    function checkPassword(password) {
        return password.length >= 10;
    }

    //check password match (registration)
    function checkPasswordMatch(password, confirmPassword) {
        return password === confirmPassword;
    }

    // color stuff
    function color(field, isValid) {
        if (isValid) {
            field.style.border = "2px solid green";
        } else {
            field.style.border = "2px solid red";
        }
    }

    // real time check for username
    if (unInput) {
        unInput.addEventListener("input", () => {
            const isValid = checkUsername(unInput.value);
            color(unInput, isValid);
        });
    }

    // real time check for password
    if (pwInput) {
        pwInput.addEventListener("input", () => {
            const isPasswordValid = checkPassword(pwInput.value);
            color(pwInput, isPasswordValid); // Update style for the password field
    
            if (confirmPwInput) {
                const passwordsMatch = checkPasswordMatch(pwInput.value, confirmPwInput.value);
                color(confirmPwInput, isPasswordValid && passwordsMatch); // both check for confirmPassword
            }
        });
    }
    
    if (confirmPwInput) {
        confirmPwInput.addEventListener("input", () => {
            const isPasswordValid = checkPassword(pwInput.value);
            const passwordsMatch = checkPasswordMatch(pwInput.value, confirmPwInput.value);
    
            color(confirmPwInput, isPasswordValid && passwordsMatch); // both check for confirmPassword
        });
    }
    

    //submission handler
    form.addEventListener("submit", (event) => {
        const usernameIsValid = unInput ? checkUsername(usernameInput.value) : true;
        const passwordIsValid = pwInput ? checkPassword(pwInput.value) : true;
        const passwordsMatch = confirmPwInput
            ? checkPasswordMatch(pwInput.value, confirmPwInput.value)
            : true;

        //msg and block if someth is wrong
        if (!usernameIsValid || !passwordIsValid || !passwordsMatch) {
            event.preventDefault(); //doesnt submit
            alert("Please correct the highlighted fields before submitting.");
        }
    });
});
