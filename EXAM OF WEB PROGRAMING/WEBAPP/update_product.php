<?php
include 'db.php'; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $product_id = filter_input(INPUT_POST, 'Prod_id', FILTER_SANITIZE_STRING);
    $product_name = filter_input(INPUT_POST, 'Prod_Name', FILTER_SANITIZE_STRING);
    $qty = filter_input(INPUT_POST, 'Quantity', FILTER_VALIDATE_INT);
    $product_uprice = filter_input(INPUT_POST, 'Unit_Price', FILTER_VALIDATE_FLOAT);
    $product_tprice = filter_input(INPUT_POST, 'Total_Price', FILTER_VALIDATE_FLOAT);

    if ($product_id && $product_name && $qty !== false && $product_uprice !== false && $product_tprice !== false) {
        // Prepare the SQL statement
        $sql = "UPDATE products SET Prod_Name = ?, Quantity = ?, Unit_Price = ?, Total_Price = ? WHERE Prod_id = ?";
        $stmt = $conn->prepare($sql);

        // Check if prepare() was successful
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("sidss", $product_name, $qty, $product_uprice, $product_tprice, $product_id);

            // Execute the statement
            if ($stmt->execute() === TRUE) {
                echo "<script>
                        alert('Product updated successfully');
                        window.location.href = 'display_products.php';
                      </script>";
            } else {
                echo "<script>alert('Error updating product: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8') . "');</script>";
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
}

// Fetch product details if ID is set
if (isset($_GET['id'])) {
    $product_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $sql = "SELECT * FROM products WHERE Prod_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<script>alert('No product ID specified'); window.location.href = 'display_products.php';</script>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
            color: #333;
        }
        input {
            margin-bottom: 20px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Product</h1>
        <form action="update_product.php" method="post">
            <input type="hidden" name="Prod_id" value="<?php echo htmlspecialchars($product['Prod_id'], ENT_QUOTES, 'UTF-8'); ?>">
            <label for="Prod_Name">Product Name:</label>
            <input type="text" id="Prod_Name" name="Prod_Name" value="<?php echo htmlspecialchars($product['Prod_Name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="Quantity">Quantity:</label>
            <input type="number" id="Quantity" name="Quantity" value="<?php echo htmlspecialchars($product['Quantity'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="Unit_Price">Unit Price:</label>
            <input type="number" step="0.01" id="Unit_Price" name="Unit_Price" value="<?php echo htmlspecialchars($product['Unit_Price'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <label for="Total_Price">Total Price:</label>
            <input type="number" step="0.01" id="Total_Price" name="Total_Price" value="<?php echo htmlspecialchars($product['Total_Price'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <button type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>
