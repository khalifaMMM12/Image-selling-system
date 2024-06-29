<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('../index.php');
}

$user_id = $_SESSION['user_id'];

// Fetch user's orders from database
$sql = "SELECT * FROM orders WHERE user_id='$user_id'";
$orders_result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/orders.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="dashboard.php">Image Shop</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="orders.php"><i class="fas fa-box"></i> My Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="upload_image.php"><i class="fas fa-upload"></i> Upload Image</a></li>
                <li class="nav-item"><a class="nav-link" href="purchased_images.php"><i class="fas fa-image"></i> Purchased Images</a></li>
                <li class="nav-item"><a class="nav-link" href="contact_us.php"><i class="fas fa-envelope"></i> Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>My Orders</h1>
        <?php
        if ($orders_result->num_rows > 0) {
            while ($order = $orders_result->fetch_assoc()) {
                ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Order ID: <?php echo $order['order_id']; ?></h5>
                        <p class="card-text">Order Date: <?php echo $order['created_at']; ?></p>
                        <p class="card-text">Total Price: ₦<?php echo $order['total_price']; ?></p>
                        
                        <?php
                        // Fetch order items
                        $order_id = $order['order_id'];
                        $sql_items = "SELECT images.title, images.filename, images.price 
                                      FROM order_items 
                                      JOIN images ON order_items.image_id = images.image_id 
                                      WHERE order_items.order_id='$order_id'";
                        $items_result = $conn->query($sql_items);

                        if ($items_result) {
                            if ($items_result->num_rows > 0) {
                                echo "<h6>Purchased Images:</h6>";
                                echo "<div class='row'>";
                                while ($item = $items_result->fetch_assoc()) {
                                    ?>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src="../images/<?php echo $item['filename']; ?>" class="card-img-top" alt="<?php echo $item['title']; ?>">
                                            <div class="card-body">
                                                <p class="card-title"><?php echo $item['title']; ?></p>
                                                <p class="card-text">Price: ₦<?php echo $item['price']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                echo "</div>";
                            } else {
                                echo "<p class='alert alert-warning'>No items found for this order.</p>";
                            }
                        } else {
                            echo "<p class='alert alert-danger'>Error fetching order items: " . $conn->error . "</p>";
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='alert alert-warning'>No orders found.</p>";
        }
        ?>
        <a href="dashboard.php" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
