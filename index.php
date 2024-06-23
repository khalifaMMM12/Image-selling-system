<?php
session_start();
include_once 'includes/db.php';

// Fetch all images from database
$sql = "SELECT * FROM images";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Catalog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <ul>
            <?php if (isset($_SESSION['admin_id'])): ?>
                <li><a href="admin/dashboard.php">Admin Dashboard</a></li>
                <li><a href="admin/logout.php">Admin Logout</a></li>
            <?php elseif (isset($_SESSION['user_id'])): ?>
                <li><a href="user/dashboard.php">User Dashboard</a></li>
                <li><a href="user/cart.php">Cart</a></li>
                <li><a href="user/orders.php">My Orders</a></li>
                <li><a href="user/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="user/login.php">User Login</a></li>
                <li><a href="user/register.php">User Register</a></li>
                <li><a href="admin/login.php">Admin Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <h1>Image Catalog</h1>
    <div class="image-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='image'>";
                echo "<img src='images/{$row['filename']}' alt='{$row['title']}'><br>";
                echo "<h3>{$row['title']}</h3>";
                echo "<p>{$row['description']}</p>";
                echo "<p>Price: \${$row['price']}</p>";
                echo "<a href='add_to_cart.php?id={$row['id']}'>Add to Cart</a>";
                echo "</div>";
            }
        } else {
            echo "No images available.";
        }
        ?>
    </div>
</body>
</html>
