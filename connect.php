<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "photops";
$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
    echo "Database Connection Failed!".$conn->connect_error;
}
?>