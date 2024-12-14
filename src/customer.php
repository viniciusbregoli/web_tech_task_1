<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = "Customer";
    $heading = "Profile Details";
    $legend = "USER INFO";
    $usernameLabel = "Username";
    $passwordLabel = "Password";
    $confirmPasswordLabel = "Confirm Password";
    $updateButtonText = "Update";
    $homeLinkText = "Home";
    $logoutLinkText = "Logout";
    ?>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/formStyle.css">
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <header>
        <h1><?php echo $heading; ?></h1>
        <a id="logout" href="logout.php"><?php echo $logoutLinkText; ?></a>
    </header>
    <form action="#">
        <fieldset>
            <legend><?php echo $legend; ?></legend>
            <label for="username"><?php echo $usernameLabel; ?></label>
            <input type="text" id="username" value="THIweb" required />
            <br>
            <label for="password"><?php echo $passwordLabel; ?></label>
            <input type="password" id="password" value="thiweb1234" required />
            <br>
            <label for="confirm_password"><?php echo $confirmPasswordLabel; ?></label>
            <input type="password" id="confirm_password" value="thiweb1234" required />
            <br><br>
            <input type="submit" value="<?php echo $updateButtonText; ?>" />
        </fieldset>
    </form>
    <footer>
        <a id="home" href="index.php"><?php echo $homeLinkText; ?></a>
    </footer>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/check.js"></script>
    <script src="./scripts/darkMode.js"></script>
</body>
</html>
