<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// echo isset($_SESSION['cart_notification']) ? 'Cart Notification Set' : 'Cart Notification Not Set';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('../index.php');
}

if (isset($_SESSION['cart_notification'])) {
    unset($_SESSION['cart_notification']);
}

// Fetch all images from database
$sql = "SELECT * FROM images WHERE approved=TRUE";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-gradient-primary">
        <a class="navbar-brand" href="dashboard.php">ImageShop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item position-relative">
                    <a class="nav-link" href="cart.php">
                        <i class="fas fa-shopping-cart"></i> Cart
                        <?php if (isset($_SESSION['cart_notification']) && $_SESSION['cart_notification'] === true): ?>
                            <span class="cart-notification-dot"></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="orders.php"><i class="fas fa-box"></i> My Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="upload_image.php"><i class="fas fa-upload"></i> Upload Image</a></li>
                <li class="nav-item"><a class="nav-link" href="purchased_images.php"><i class="fas fa-images"></i> Purchased Images</a></li>
                <li class="nav-item"><a class="nav-link" href="contact_us.php"><i class="fas fa-envelope"></i> Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Image Catalog</h1>
        <div class="row">
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="../images/<?= $row['filename'] ?>" class="card-img-top" alt="<?= $row['title'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['title'] ?></h5>
                                <p class="card-text"><?= $row['description'] ?></p>
                                <p class="card-text">Price: ₦<?= $row['price'] ?></p>
                                <form method="post" action="../add_to_cart.php">
                                    <input type="hidden" name="image_id" value="<?= $row['image_id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12">
                    <p class="text-center">No images available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cartLink = document.querySelector('.nav-link[href="cart.php"]');
            if (cartLink) {
                cartLink.addEventListener('click', function() {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'clear_cart_notification.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.send();
                });
            }
        });
    </script>
</body>
</html>
