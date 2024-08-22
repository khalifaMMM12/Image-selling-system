<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/function.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('user/../index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image_id = sanitize_input($_POST['image_id']);
    $user_id = $_SESSION['user_id'];

    // Check if the image is already in the cart
    $sql = "SELECT * FROM cart WHERE user_id = ? AND image_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $image_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert the image into the cart
        $sql_insert = "INSERT INTO cart (user_id, image_id) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param('ii', $user_id, $image_id);

        if ($stmt_insert->execute()) {
            // Set session variable to indicate that the cart was updated
            $_SESSION['cart_notification'] = true;
            $_SESSION['success_message'] = "Image added to cart successfully.";
        } else {
            // Log error and show message
            error_log("SQL Error: " . $stmt_insert->error);
            $_SESSION['error_message'] = "Error adding image to cart.";
        }

        $stmt_insert->close();
    } else {
        // Image is already in the cart
        $_SESSION['error_message'] = "Image is already in your cart.";
    }

    $stmt->close();
    // Redirect to the user dashboard
    redirect('user/dashboard.php');
} else {
    // Invalid request method
    $_SESSION['error_message'] = "Invalid request method.";
    redirect('user/dashboard.php');
}
?>
