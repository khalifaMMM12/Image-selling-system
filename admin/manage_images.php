<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    redirect('../index.php');
}

// Fetch all images from database
$sql = "SELECT * FROM images WHERE approved=TRUE";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve images</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Approve images</h1>
    <div class="image-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='image'>";
                echo "<img src='../images/{$row['filename']}' alt='{$row['title']}'><br>";
                echo "<h3>{$row['title']}</h3>";
                echo "<p>{$row['description']}</p>";
                echo "<p>Price:₦{$row['price']}</p>";
                echo "</div>";
            }
        } else {
            echo "No images found.";
        }
        ?>
    </div>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
