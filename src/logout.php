<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./css/logoutStyle.css">
        <title>Logout</title>
    </head>
    <body>
        <header>
            <h1>LOGGED OUT</h1>
        </header>
        <div id="logout-block">
            <p>Thank you for using <strong>Tech Shop</strong></p>
            <button id="login" onclick="location.href='login.php'">Login</button>
            <button onclick="location.href='index.php'">Home</button>
        </div>
        <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
        <script src="./scripts/darkMode.js"></script>
        <script src="../scripts/screenWidth.js"></script>
    </body>
</html>