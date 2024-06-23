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
$result = $conn->query($sql);
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
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<p>Order ID: {$row['id']}</p>";
            echo "<p>Order Details: {$row['details']}</p>";
            echo "<p>Total Price: {$row['total_price']}</p>";
            echo "</div>";
        }
    } else {
        echo "No orders found.";
    }
    ?>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
