<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "content_writing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    //echo"Database successfully established!";
}
?>
