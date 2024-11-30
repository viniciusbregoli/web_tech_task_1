<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./css/formStyle.css">
        <title>Login</title>
    </head>
    <body>
        <header>
            <h1>Access Your Account</h1>
        </header>
        <form action="#">
            <fieldset>
                <legend>LOGIN</legend>
                <label for="username">Username</label>
                <input type="text" id="username" required />
                </br>
                <label for="password">Password</label>
                <input type="password" id="password" required />
                </br>
                </br>
                <input type="submit" value="Login" />
                <button type="button" onclick="location.href='registration.php'">Register</button> 
            </fieldset>
        </form>
        <footer>
            <a id="home" href="index.php">Home</a>
        </footer>
        <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
        <script src="./scripts/checklogin.js"></script>
        <script src="./scripts/darkMode.js"></script>
    </body>
</html>
