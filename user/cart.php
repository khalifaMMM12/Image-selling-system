<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('../index.php');
}

// If the user views the cart, reset the cart notification
if (isset($_SESSION['cart_updated'])) {
    unset($_SESSION['cart_updated']);
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from database
$sql = "SELECT images.* FROM cart JOIN images ON cart.image_id = images.image_id WHERE cart.user_id='$user_id'";
$result = $conn->query($sql);

// Initialize total price
$total_price = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/cart.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg ">
        <a class="navbar-brand" href="dashboard.php">ImageShop</a>
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
        <h1>My Cart</h1>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $total_price += $row['price'];
                    ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="../images/<?php echo $row['filename']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                                <p class="card-text">Price: ₦<?php echo $row['price']; ?></p>
                                <a href='remove_from_cart.php?image_id=<?php echo $row['image_id']; ?>' class="btn btn-danger"><i class="fas fa-trash-alt"></i> Remove</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='col-12'><p class='alert alert-warning'>Your cart is empty.</p></div>";
            }
            ?>
        </div>
        <h2>Total Price: ₦<?php echo $total_price; ?></h2>
        <?php if ($total_price > 0) : ?>
            <form method="post" action="payment.php">
                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                <button type="submit" class="btn btn-success"><i class="fas fa-credit-card"></i> Proceed to Purchase</button>
            </form>
        <?php endif; ?>
        <br>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
