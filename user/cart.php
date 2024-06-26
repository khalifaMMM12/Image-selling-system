<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('login.php');
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
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>My Cart</h1>
    <div class="cart-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total_price += $row['price'];
                ?>
                <div class='cart-item'>
                    <img src='../images/<?php echo $row['filename']; ?>' alt='<?php echo $row['title']; ?>'><br>
                    <h3><?php echo $row['title']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <p>Price: ₦<?php echo $row['price']; ?></p>
                    <a href='remove_from_cart.php?image_id=<?php echo $row['image_id']; ?>'>Remove</a>
                </div>
                <?php
            }
        } else {
            echo "Your cart is empty.";
        }
        ?>
    </div>
    <h2>Total Price: ₦<?php echo $total_price; ?></h2>
    <?php if ($total_price > 0) : ?>
        <form method="post" action="../purchase.php">
            <button type="submit">Proceed to Purchase</button>
        </form>
    <?php endif; ?>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
