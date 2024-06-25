<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('./index.php');
}

// Fetch all images from database
$sql = "SELECT * FROM images";
$result = $conn->query($sql);
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
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="orders.php">My Orders</a></li>
            <li><a href="upload_image.php">Upload Image</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Image Catalog</h1>
    <div class="image-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='image'>";
                echo "<img src='../images/{$row['filename']}' alt='{$row['title']}'><br>";
                echo "<h3>{$row['title']}</h3>";
                echo "<p>{$row['description']}</p>";
                echo "<p>Price: \₦{$row['price']}</p>";
                echo "<form method='post' action='add_to_cart.php'>";
                echo "<input type='hidden' name='image_id' value='{$row['id']}'>";
                echo "<button type='submit'>Add to Cart</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "No images available.";
        }
        ?>
    </div>
</body>
</html>
