<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// Check if image_id is provided
if (isset($_GET['image_id'])) {
    $image_id = sanitize_input($_GET['image_id']);
    
    // Remove item from cart
    $sql = "DELETE FROM cart WHERE user_id='$user_id' AND image_id='$image_id'";
    if ($conn->query($sql) === TRUE) {
        redirect('cart.php');
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    redirect('cart.php');
}
?>
