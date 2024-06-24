<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('user/login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image_id = sanitize_input($_POST['image_id']);
    $user_id = $_SESSION['user_id'];

    // Check if image is already in the cart
    $sql = "SELECT * FROM cart WHERE user_id='$user_id' AND image_id='$image_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Insert image into the cart
        $sql = "INSERT INTO cart (user_id, image_id) VALUES ('$user_id', '$image_id')";
        if ($conn->query($sql) === TRUE) {
            echo "Image added to cart.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Image already in the cart.";
    }

    redirect('user/cart.php');
} else {
    echo "Invalid request method.";
}
?>
