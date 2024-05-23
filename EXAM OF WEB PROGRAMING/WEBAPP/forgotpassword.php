<?php
// Include database connection file
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $email = filter_input(INPUT_POST, 'forgot_email', FILTER_SANITIZE_EMAIL);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location.href='userform.html';</script>";
        exit();
    }

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT Username FROM users WHERE `E-mail` = ?");
    if ($stmt === false) {
        die("Error preparing SQL statement: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows == 0) {
        echo "<script>alert('Email not found'); window.location.href='login.html';</script>";
        exit();
    }

    // Generate a random temporary password
    $temp_password = bin2hex(random_bytes(8));

    // Hash the temporary password
    $hashed_temp_password = password_hash($temp_password, PASSWORD_BCRYPT);

    // Update the user's password with the temporary password
    $stmt = $conn->prepare("UPDATE users SET Password = ? WHERE `E-mail` = ?");
    if ($stmt === false) {
        die("Error preparing SQL statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $hashed_temp_password, $email);
    $stmt->execute();
    $stmt->close();

    // Send the temporary password to the user's email (implementation required)

    // Display a success message
    echo "<script>alert('Password reset successful. Check your email for the temporary password.'); window.location.href='Homepage.html';</script>";
}

// Close the connection
$conn->close();
?>
