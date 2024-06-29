<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    redirect('../index.php');
}

// Approve image
if (isset($_GET['approve'])) {
    $image_id = sanitize_input($_GET['approve']);
    $sql = "UPDATE images SET approved=TRUE WHERE image_id='$image_id'";
    if ($conn->query($sql) === TRUE) {
        $feedback = "Image approved successfully.";
    } else {
        $feedback = "Error: " . $sql . "<br>" . $conn->error;
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand"><i class="fas fa-home"></i> Admin</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="manage_users.php"><i class="fas fa-users"></i> Users</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_approve.php"><i class="fas fa-check"></i> Approve Images</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_orders.php"><i class="fas fa-box"></i> Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center">Approve Images</h1>
        <?php if (isset($feedback)): ?>
            <div class="alert alert-info text-center"><?php echo $feedback; ?></div>
        <?php endif; ?>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card'>";
                    echo "<img src='../images/{$row['filename']}' class='card-img-top' alt='{$row['title']}'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['title']}</h5>";
                    echo "<p class='card-text'>{$row['description']}</p>";
                    echo "<p class='card-text'><strong>Price:</strong> ₦{$row['price']}</p>";
                    echo "<a href='admin_approve.php?approve={$row['image_id']}' class='btn btn-success'><i class='fas fa-check'></i> Approve</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12 text-center'><p>No images pending approval.</p></div>";
            }
            ?>
        </div>
        <a href="dashboard.php" class="btn btn-secondary mt-4"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
