<?php
include 'database.php';

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];

$sql = "UPDATE products SET product_name='$product_name', product_price='$product_price' WHERE product_id=$product_id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Product updated successfully');</script>";
} else {
    echo "<script>alert('Error updating product: " . $conn->error . "');</script>";
}

$conn->close();
?>
