<?php
session_start();
include_once 'includes/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please login to purchase images.";
    exit();
}

// Fetch cart items (you need to implement this based on how you store cart items)
if (isset($_SESSION['cart'])) {
    $cart_items = $_SESSION['cart'];

    // Calculate total price and generate order details
    $total_price = 0;
    $order_details = "Ordered Images:\n";

    foreach ($cart_items as $image_id) {
        $sql = "SELECT * FROM images WHERE id='$image_id'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $image = $result->fetch_assoc();
            $total_price += $image['price'];
            $order_details .= "Title: {$image['title']}, Price: {$image['price']}\n";
            // Implement logic to mark image as purchased or add to user's purchased images list
        }
    }

    // INSERT INTO orders (user_id, details, total_price) VALUES ($_SESSION['user_id'], '$order_details', $total_price);
    // unset($_SESSION['cart']);

    echo "Purchase successful. Total price: $total_price";
} else {
    echo "Your cart is empty.";
}
?>
