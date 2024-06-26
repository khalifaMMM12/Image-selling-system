<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch user's orders from database
$sql = "SELECT * FROM orders WHERE user_id='$user_id'";
$orders_result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>My Orders</h1>
    <?php
    if ($orders_result->num_rows > 0) {
        while ($order = $orders_result->fetch_assoc()) {
            echo "<div>";
            echo "<p>Order ID: {$order['id']}</p>";
            echo "<p>Order Date: {$order['created_at']}</p>";
            echo "<p>Total Price: ₦{$order['total_price']}</p>";
            
            // Fetch order items
            $order_id = $order['id'];
            $sql = "SELECT images.title, images.filename, images.price 
                    FROM order_items 
                    JOIN images ON order_items.image_id = images.id 
                    WHERE order_items.order_id='$order_id'";
            $items_result = $conn->query($sql);
            
            if ($items_result->num_rows > 0) {
                echo "<h3>Purchased Images:</h3>";
                echo "<div class='order-items'>";
                while ($item = $items_result->fetch_assoc()) {
                    echo "<div class='order-item'>";
                    echo "<img src='./images/{$item['filename']}' alt='{$item['title']}'><br>";
                    echo "<p>{$item['title']}</p>";
                    echo "<p>Price: ₦{$item['price']}</p>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No items found for this order.</p>";
            }
            
            echo "</div><hr>";
        }
    } else {
        echo "No orders found.";
    }
    ?>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
