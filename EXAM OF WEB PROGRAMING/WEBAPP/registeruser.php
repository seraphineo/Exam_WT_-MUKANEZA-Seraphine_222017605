<?php
// Include database connection file
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location.href='userform.html';</script>";
        exit();
    }
    
    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE Username = ? OR `E-mail` = ?");
    if ($stmt === false) {
        die("Error preparing SQL statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<script>alert('Username or email already exists'); window.location.href='userform.html';</script>";
        exit();
    }
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    // Prepare and bind the insert statement
    $stmt = $conn->prepare("INSERT INTO users (Username, `E-mail`, Password) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing SQL statement: " . $conn->error);
    }
    
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('User registered successfully'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='userfrom.html';</script>";
    }
    
    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
