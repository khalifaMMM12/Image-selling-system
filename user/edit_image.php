<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('login.php');
}

// Fetch image details
if (isset($_GET['id'])) {
    $image_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM images WHERE id='$image_id' AND user_id='$user_id'";
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);

    // Update image details
    $sql = "UPDATE images SET title='$title', description='$description' WHERE id='$image_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Image details updated successfully.";
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
    <title>Edit Image</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Edit Image</h1>
    <form method="post">
        <input type="text" name="title" placeholder="Title" value="<?php echo $image['title']; ?>" required><br>
        <textarea name="description" placeholder="Description" required><?php echo $image['description']; ?></textarea><br>
        <button type="submit">Save Changes</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
