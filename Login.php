<?php
    session_start();
    if(isset($_SESSION['email'])){
        header("Location: Index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        <link rel="stylesheet" href="CSS/Style.css">
        <link rel="stylesheet" href="CSS/Login.css">
    </head>
    <body>        
        <h1>Login</h1>
        <form id="login_form" method="post" action="db_handle.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="login-checkup">
                <input type="checkbox" id="show_password" onclick="myFunction()" name="show_password"> 
                <p>Show Password</p>
            </div>
            <input type="submit" value="Login" name="Login_btn">
            <p>Don't have an account? <a href="#" id="openRegisterLink">Register</a></p>
        </form>
        <script src="Script.js"></script>
    </body>
</html>
