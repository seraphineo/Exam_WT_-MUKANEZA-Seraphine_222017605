<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script>
        // Redirect to the login page or homepage
        window.onload = function() {
            alert("You have been logged out.");
            window.location.href = "loginuser.php"; // Adjust the location as necessary
        };
    </script>
</head>
<body>
</body>
</html>
