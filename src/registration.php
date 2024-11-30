<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./css/formStyle.css">
        <title>Document</title>
    </head>
    <body>
        <h1>Join Us</h1>
        <form action="#">
            <fieldset>
                <legend>REGISTRATION</legend>
                <label for="username">Username</label>
                <input type="text" id="username" required />
                </br>
                <label for="password">Password</label>
                <input type="password" id="password" required />
                </br>
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" required />
                </br>
                </br>
                <input type="submit" value="Submit" />
                <button type="button" onclick="location.href='login.php'">Back to Login</button> 
            </fieldset>
        </form>
        <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
        <script src="./scripts/check.js"></script>
        <script src="./scripts/darkMode.js"></script>
        <script src="../scripts/screenWidth.js"></script>
    </body>
</html>
