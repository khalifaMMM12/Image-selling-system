<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('../index.php');
}

// Simulate payment processing (replace with payment gateway integration)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $cardholder_name = sanitize_input($_POST['cardholder_name']);
    $card_number = sanitize_input($_POST['card_number']);
    $expiry_date = sanitize_input($_POST['expiry_date']);
    $cvv = sanitize_input($_POST['cvv']);
    $total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;

    // Simulate successful payment
    if ($total_price > 0) {
        // Empty the user's cart
        $sql = "DELETE FROM cart WHERE user_id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            // Insert order into orders table
            $sql_order = "INSERT INTO orders (user_id, total_price, created_at) VALUES ('$user_id', '$total_price', NOW())";
            if ($conn->query($sql_order) === TRUE) {
                $_SESSION['success_message'] = "Payment successful and order placed!";
                $_SESSION['payment_verified'] = true;  // Set this to trigger the modal
                $_SESSION['total_price'] = 0;  // Clear the cart total price
                redirect('payment.php');  // Redirect to payment page to show the modal
            } else {
                $_SESSION['error_message'] = "Failed to place the order.";
                redirect('cart.php');
            }
        } else {
            $_SESSION['error_message'] = "Failed to clear the cart.";
            redirect('cart.php');
        }
    } else {
        $_SESSION['error_message'] = "No items in cart.";
        redirect('cart.php');
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    redirect('cart.php');
}
