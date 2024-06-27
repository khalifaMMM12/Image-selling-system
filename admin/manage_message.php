<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

// Fetch all messages from database
$sql = "SELECT contact_messages.*, users.username FROM contact_messages JOIN users ON contact_messages.user_id = users.id ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Messages</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage_users.php">Users</a></li>
            <li><a href="admin_approve.php">images</a></li>
            <li><a href="manage_orders.php">Manage Orders</a></li>
            <li><a href="manage_message.php">Feedbacks</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Manage Messages</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['subject']}</td>";
                echo "<td>{$row['message']}</td>";
                echo "<td>{$row['created_at']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No messages found.</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
