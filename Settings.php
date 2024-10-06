<?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: Index.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Account Settings</title>
        <link rel="stylesheet" href="CSS/Settings.css">
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="Index.php">Logo</a></li>
                </ul>
            </nav>
        </header>
        <div class="settingsContainer">
            <h2>Account Settings</h2>
            <form id="SettingsUser" method="POST" action="db_handle.php">
                    <label>Change Username</label>
                    <input type="text" name="username" placeholder="Enter new username" required/>
                    <input type="submit" value="Save" name="saveUsername" /><br><br>
            </form>
            <form id="SettingsPass" method="POST" action="db_handle.php">
                <label>Change Password</label>
                <input type="password" name="oldPassword" placeholder="Enter old password" required /><br>
                <input type="password" name="password" placeholder="Enter new password" required /><br>
                <input type="password" name="confirmPassword" placeholder="Confirm new password" required /><br>
                <input type="submit" value="Save" name="savePassword" />
            </form>
        </div>
        <script src="Script.js"></script>
    </body>
</html>