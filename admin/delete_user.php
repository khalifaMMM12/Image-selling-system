<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

// Check if user ID is provided
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    
    // Delete user from database
    $sql = "DELETE FROM users WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "User deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting user: " . $conn->error;
    }
} else {
    $_SESSION['message'] = "No user ID provided.";
}

redirect('manage_users.php');
?>
