<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('../index.php');
}

$user_id = $_SESSION['user_id'];

// Get the total price from the session or the POST request
if (isset($_POST['total_price'])) {
    $total_price = $_POST['total_price'];
    $_SESSION['total_price'] = $total_price; // Store it in session for later use
} else {
    $total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;
}

if ($total_price == 0) {
    $_SESSION['error_message'] = "No items in your cart to proceed with payment.";
    redirect('cart.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
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
        <h1 class="text-center">Payment</h1>
        <form action="process_payment.php" method="POST">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="form-group">
                        <label for="cardholder_name">Cardholder Name</label>
                        <input type="text" class="form-control" id="cardholder_name" name="cardholder_name" placeholder="Name on the card" required>
                    </div>
                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="16" required>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" maxlength="3" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Total Amount</label>
                        <input type="text" class="form-control" value="₦<?php echo number_format($total_price, 2); ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-credit-card"></i> Pay Now</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
