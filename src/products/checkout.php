<?php 
    session_start();
    print_r("sdfsdf");
    if(isset($_SESSION['username'])){
        header("Location: shopping.php");
    } else {
        echo "<script>
                    alert(\"You need to be logged in to proceed with your purchase.\");
                    window.location.href = \"../login.php\";
                </script>";
    }
    
?>