<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('user/login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from database
$sql = "SELECT images.* FROM cart JOIN images ON cart.image_id = images.image_id WHERE cart.user_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $order_details = "";
    $total_price = 0;

    while ($row = $result->fetch_assoc()) {
        $order_details .= "Image: {$row['title']} - Price: \${$row['price']}\n";
        $total_price += $row['price'];
    }

    // Insert order into database
    $sql = "INSERT INTO orders (user_id, details, total_price) VALUES ('$user_id', '$order_details', '$total_price')";
    if ($conn->query($sql) === TRUE) {
        // Clear user's cart
        $sql = "DELETE FROM cart WHERE user_id='$user_id'";
        $conn->query($sql);

        echo "Purchase completed successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Your cart is empty.";
}

redirect('user/orders.php');
?>
