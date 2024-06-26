<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

// Approve image
if (isset($_GET['approve'])) {
    $image_id = sanitize_input($_GET['approve']);
    $sql = "UPDATE images SET approved=TRUE WHERE image_id='$image_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Image approved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all unapproved images
$sql = "SELECT * FROM images WHERE approved=FALSE";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Images</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="admin_approve_images.php">Approve Images</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Approve Images</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<img src='../images/{$row['filename']}' alt='{$row['title']}'><br>";
            echo "<p>Title: {$row['title']}</p>";
            echo "<p>Description: {$row['description']}</p>";
            echo "<p>Price: {$row['price']}</p>";
            echo "<a href='admin_approve_images.php?approve={$row['image_id']}'>Approve</a>";
            echo "</div><hr>";
        }
    } else {
        echo "No images pending approval.";
    }
    ?>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
