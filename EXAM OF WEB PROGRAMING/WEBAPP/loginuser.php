<?php
// Include database connection file
include 'db.php';
// Start the session
session_start();

// Hardcoded username and password
$correct_username = "Sarah";
$correct_password = "Sarah123";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if the username and password match the hardcoded values
    if ($username === $correct_username && $password === $correct_password) {
        // Authentication successful
        // Set session variables and display success message using JavaScript
        $_SESSION['username'] = $username;
        echo "<script>alert('Login successful'); window.location.href='Homepage.html';</script>";
        exit();
    } else {
        // Authentication failed
        // Display error message using JavaScript
        echo "<script>alert('Invalid username or password'); window.location.href='login.html';</script>";
        exit();
    }
} else {
    // If the form is not submitted, redirect to the login page
    header("Location: login.html");
    exit();
}
?>
