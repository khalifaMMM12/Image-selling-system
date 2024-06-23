<?php
session_start();
include_once 'includes/db.php';

if (isset($_GET['id'])) {
    $image_id = $_GET['id'];

    // Add image to cart (you can implement this functionality based on your specific requirements)
    // For example, you can store the image ID in $_SESSION['cart'] array

    echo "Image added to cart successfully."; // You can redirect to the previous page or cart page
} else {
    echo "Image ID not provided.";
}
?>
