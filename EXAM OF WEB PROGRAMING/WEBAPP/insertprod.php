<?php
include 'db.php'; // Include your database connection script

// Validate and sanitize input data
$product_id = filter_input(INPUT_POST, 'Prod_id', FILTER_SANITIZE_STRING);
$product_name = filter_input(INPUT_POST, 'Prod_Name', FILTER_SANITIZE_STRING);
$qty = filter_input(INPUT_POST, 'Quantity', FILTER_VALIDATE_INT);
$product_uprice = filter_input(INPUT_POST, 'Unit_Price', FILTER_VALIDATE_FLOAT);
$product_tprice = filter_input(INPUT_POST, 'Total_Price', FILTER_VALIDATE_FLOAT);

if ($product_id && $product_name && $qty !== false && $product_uprice !== false && $product_tprice !== false) {
    // Prepare the SQL statement
    $sql = "INSERT INTO products (Prod_id, Prod_Name, Quantity, Unit_Price, Total_Price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if prepare() was successful
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssidd", $product_id, $product_name, $qty, $product_uprice, $product_tprice);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "<script>
                    alert('Product added successfully');
                    window.location.href = 'display_products.php';
                  </script>";
        } else {
            echo "<script>alert('Error adding product: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8') . "');</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Prepare statement failed
        echo "<script>alert('Error preparing SQL statement: " . htmlspecialchars($conn->error, ENT_QUOTES, 'UTF-8') . "');</script>";
    }
} else {
    echo "<script>alert('Invalid input data');</script>";
}

// Close the database connection
$conn->close();
?>
