<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

// Fetch all orders from database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Manage Orders</h1>
    <table>
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Details</th>
            <th>Total Price</th>
            <th>Date</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['order_id']}</td>";
                echo "<td>{$row['user_id']}</td>";
                echo "<td>{$row['details']}</td>";
                echo "<td>{$row['total_price']}</td>";
                echo "<td>{$row['created_at']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No orders found.</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
