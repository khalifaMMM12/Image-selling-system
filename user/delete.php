<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('../index.php');
}

// Fetch image details
if (isset($_GET['id'])) {
    $image_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Delete image from database
    $sql = "DELETE FROM images WHERE id='$image_id' AND user_id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        // Delete image file from server (optional)
        echo "Image deleted successfully.";
    } else {
        echo "Error deleting image: " . $conn->error;
    }
} else {
    echo "Image ID not provided.";
}
?>
