<?php
include 'db.php'; // Include your database connection script

if (isset($_GET['id'])) {
    $product_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $sql = "DELETE FROM products WHERE Prod_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $product_id);

    if ($stmt->execute() === TRUE) {
        echo "<script>
                alert('Product deleted successfully');
                window.location.href = 'display_products.php';
              </script>";
    } else {
        echo "<script>alert('Error deleting product: " . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8') . "');</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('No product ID specified'); window.location.href = 'display_products.php';</script>";
}

$conn->close();
?>
