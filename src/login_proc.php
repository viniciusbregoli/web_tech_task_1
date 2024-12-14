<?php
    session_start();

    include('db_connect.php');
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check user
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // if user exists
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            echo "<script>
                    var username = '" . $user['username'] . "';
                </script>";
            // If the password is correct, store user info in the session.
            $_SESSION['username'] = $user['username'];
            echo "<script>
                    alert(\"Login successful! Welcome back.\");
                </script>";
            //header("Location: index.php");
        } else {
            // Incorrect password
            echo "<script>
                    alert(\"Password does not match.\");
                    history.back();
                </script>";
        }
    } else {
        // Unregistered user
        echo "<script>
                alert(\"You are an unregistered user.\");
                history.back();
            </script>";
    }
?>