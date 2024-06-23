<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>User Dashboard</h1>
    <ul>
        <li><a href="upload_image.php">Upload Image</a></li>
        <li><a href="purchased_images.php">My Purchased Images</a></li>
        <li><a href="orders.php">My Orders</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</body>
</html>
