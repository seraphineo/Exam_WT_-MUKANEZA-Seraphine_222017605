<?php
include 'database.php';

$product_id = $_POST['product_id'];

$sql = "DELETE FROM products WHERE product_id=$product_id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Product deleted successfully');</script>";
} else {
    echo "<script>alert('Error deleting product: " . $conn->error . "');</script>";
}

$conn->close();
?>