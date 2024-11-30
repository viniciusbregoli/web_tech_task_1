<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/formStyle.css">
        <title>Customer</title>
    </head>
    <body>
        <header>
            <h1>Profile Details</h1>
            <a id="logout" href="logout.php">Logout</a>
        </header>
        <form action="#">
            <fieldset>
                <legend>USER INFO</legend>
                <label for="username">Username</label>
                <input type="text" id="username" value="THIweb" required />
                </br>
                <label for="password">Password</label>
                <input type="password" id="password" value="thiweb1234" required />
                </br>
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" value="thiweb1234" required />
                </br>
                </br>
                <input type="submit" value="Update" />
            </fieldset>
        </form>
        <footer>
            <a id="home" href="index.php">Home</a>
        </footer>
        <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
        <script src="./scripts/check.js"></script>
        <script src="./scripts/darkMode.js"></script>
        <script src="../scripts/screenWidth.js"></script>
    </body>
</html>
