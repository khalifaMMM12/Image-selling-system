<?php
include_once '../includes/db.php';

// Example code to add an admin user (this should be run once to create an admin)
$admin_username = 'admin';
$admin_password = password_hash('adminpass', PASSWORD_DEFAULT);
$sql = "INSERT INTO admins (username, password) VALUES ('$admin_username', '$admin_password')";
if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
