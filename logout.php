<?php
session_start();
session_destroy(); // Destroy the session
header('Location: Index.php'); // Redirect to the home page
exit();
?>
