<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
}

$image_id = sanitize_input($_GET['id']);

// Fetch image details from database
$sql = "SELECT * FROM images WHERE id='$image_id'";
$result = $conn->query($sql);
$image = $result->fetch_assoc();

if (!$image) {
    echo "Image not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Image</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1><?php echo $image['title']; ?></h1>
    <img src="../images/<?php echo $image['filename']; ?>" alt="<?php echo $image['title']; ?>">
    <p><?php echo $image['description']; ?></p>
    <p>Price: $<?php echo $image['price']; ?></p>
    <form method="post" action="../add_to_cart.php">
        <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
        <button type="submit">Add to Cart</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
