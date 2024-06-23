<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/functions.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('login.php');
}

$user_id = $_SESSION['user_id'];

// Fetch user's uploaded images
$sql = "SELECT * FROM images WHERE user_id='$user_id'";
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
    <h1>Welcome to Your Dashboard</h1>
    <h2>Uploaded Images:</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<img src='../images/{$row['filename']}' alt='{$row['title']}'><br>";
            echo "<h3>{$row['title']}</h3>";
            echo "<p>{$row['description']}</p>";
            echo "<a href='edit_image.php?id={$row['id']}'>Edit</a> | ";
            echo "<a href='delete_image.php?id={$row['id']}'>Delete</a>";
            echo "</div>";
        }
    } else {
        echo "No images uploaded.";
    }
    ?>
    <br>
    <a href="upload_image.php">Upload New Image</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
