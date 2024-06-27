<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $price = sanitize_input($_POST['price']);
    $user_id = $_SESSION['user_id'];

    // Handle file upload
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $filename = basename($_FILES["image"]["name"]);
            // Insert image details into database with approved set to FALSE
            $sql = "INSERT INTO images (title, description, price, filename, user_id, approved) VALUES ('$title', '$description', '$price', '$filename', '$user_id', FALSE)";
            if ($conn->query($sql) === TRUE) {
                echo "Image uploaded successfully and is pending approval.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
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
    <h1>Upload Image</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="text" name="price" placeholder="Price" required><br>
        <input type="file" name="image" required><br>
        <button type="submit">Upload</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
