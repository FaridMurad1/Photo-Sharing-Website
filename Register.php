<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="CSS/Register.css">
</head>
<body>
    <link rel="stylesheet" href="CSS/Register.css">
    <h1>Register</h1>
    <form id="register_form" method="post" action="db_handle.php">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <div class="login-checkup">
            <input type="checkbox" id="show_password" name="show_password"> 
            <p>Show Password</p>
        </div>
        <input type="submit" value="Register" name="Register_btn">
        <p>Already have an account? <a href="#" id="openLoginLink">Login</a></p>
    </form>
</body>
    
    <script src="Script.js"></script>
</html>

