<?php
include 'db.php'; // Include your database connection script

// Fetch all products to display
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #3498db;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
        }
        .button:hover {
            background-color: #2980b9;
        }
        .button:active {
            background-color: #2980b9;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product List</h1>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
            <?php
            // Display the products in a table
            if ($result->num_rows > 0) {
                // Fetch and display each row of the result set
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['Prod_id'], ENT_QUOTES, 'UTF-8') . "</td>
                            <td>" . htmlspecialchars($row['Prod_Name'], ENT_QUOTES, 'UTF-8') . "</td>
                            <td>" . htmlspecialchars($row['Quantity'], ENT_QUOTES, 'UTF-8') . "</td>
                            <td>" . htmlspecialchars($row['Unit_Price'], ENT_QUOTES, 'UTF-8') . "</td>
                            <td>" . htmlspecialchars($row['Total_Price'], ENT_QUOTES, 'UTF-8') . "</td>
                            <td>
                                <a href='update_product.php?id=" . htmlspecialchars($row['Prod_id'], ENT_QUOTES, 'UTF-8') . "'>Update</a> |
                                <a href='delete_product.php?id=" . htmlspecialchars($row['Prod_id'], ENT_QUOTES, 'UTF-8') . "' onclick=\"return confirm('Are you sure you want to delete this product?');\">Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No products found.</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </table>
        <a class="button" href="product.html">Add New Product</a>
        <a class="button" href="Homepage.html">Back Home</a>
    </div>
</body>
</html>
