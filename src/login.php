<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = "Login";
    $heading = "Access Your Account";
    $legend = "LOGIN";
    $usernameLabel = "Username";
    $passwordLabel = "Password";
    $loginButtonText = "Login";
    $registerButtonText = "Register";
    $homeLinkText = "Home";
    $adm="Admin login";
    
    $redirectUrl = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/formStyle.css">
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <header>
        <h1><?php echo $heading; ?></h1>
    </header>
    <form method="post" action=<?php echo "login_proc.php?redirect=$redirectUrl"?>>
        <fieldset>
            <legend><?php echo $legend; ?></legend>
            <label for="username"><?php echo $usernameLabel; ?></label>
            <input type="text" id="username" name="username" required />
            <br>
            <label for="password"><?php echo $passwordLabel; ?></label>
            <input type="password" id="password" name="password" required />
            <br><br>
            <input type="submit" value="<?php echo $loginButtonText; ?>" />
            <button type="button" onclick="location.href='registration.php'"><?php echo $registerButtonText; ?></button>
        </fieldset>
    </form>
    <footer>
        <a id="home" href="index.php"><?php echo $homeLinkText; ?></a>
        <a id="adm" href="admin_login.php"><?php echo $adm ?></a>
    </footer>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/checklogin.js"></script>
    <script src="./scripts/darkMode.js"></script>
</body>
</html>
