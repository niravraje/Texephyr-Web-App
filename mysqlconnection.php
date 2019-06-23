<?php
$servername = "localhost";
$username = "root";
$password = "nirav@123";
$dbname = "tex17";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>
