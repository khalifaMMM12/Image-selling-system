<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

if (isset($_GET['image_id'])) {
    $image_id = sanitize_input($_GET['image_id']);
    $user_id = $_SESSION['user_id'];

    // Remove item from cart
    $sql = "DELETE FROM cart WHERE image_id='$image_id' AND user_id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Item removed from cart.";
    } else {
        echo "Error: " . $conn->error;
    }
}

redirect('cart.php');
?>
