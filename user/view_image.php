<?php
session_start();
include_once 'includes/db.php';

if (isset($_GET['id'])) {
    $image_id = $_GET['id'];

    // Fetch image details from database
    $sql = "SELECT * FROM images WHERE id='$image_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $image = $result->fetch_assoc();
    } else {
        echo "Image not found.";
        exit();
    }
} else {
    echo "Image ID not provided.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Image</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1><?php echo $image['title']; ?></h1>
    <div class="image">
        <img src="images/<?php echo $image['filename']; ?>" alt="<?php echo $image['title']; ?>"><br>
        <p><?php echo $image['description']; ?></p>
        <p>Price: <?php echo $image['price']; ?></p>
        <a href="add_to_cart.php?id=<?php echo $image['id']; ?>">Add to Cart</a>
    </div>
</body>
</html>
