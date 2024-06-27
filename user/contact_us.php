<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $subject = sanitize_input($_POST['subject']);
    $message = sanitize_input($_POST['message']);

    // Insert message into database
    $sql = "INSERT INTO contact_messages (user_id, subject, message) VALUES ('$user_id', '$subject', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo "Message sent successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="orders.php">My Orders</a></li>
            <li><a href="upload_image.php">Upload Image</a></li>
            <li><a href="purchased_images.php">Purchased Images</a></li>
            <li><a href="contact_us.php">Contact Us</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Contact Us</h1>
    <form method="post" action="contact_us.php">
        <input type="text" name="subject" placeholder="Subject" required><br>
        <textarea name="message" placeholder="Message" required></textarea><br>
        <button type="submit">Send</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
