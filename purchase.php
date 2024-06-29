<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/function.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    redirect('user/../index.php');
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from database
$sql = "SELECT images.* FROM cart JOIN images ON cart.image_id = images.image_id WHERE cart.user_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $order_details = "";
    $total_price = 0;

    // Start transaction
    $conn->begin_transaction();

    try {
        while ($row = $result->fetch_assoc()) {
            $order_details .= "Image: {$row['title']} - Price: ₦{$row['price']}\n";
            $total_price += $row['price'];
        }

        // Insert order into database
        $sql = "INSERT INTO orders (user_id, total_price) VALUES ('$user_id', '$total_price')";
        if ($conn->query($sql) === TRUE) {
            $order_id = $conn->insert_id;

            // Add order items
            $result->data_seek(0); // Reset result pointer to the beginning
            while ($row = $result->fetch_assoc()) {
                $image_id = $row['image_id'];
                $sql = "INSERT INTO order_items (order_id, image_id) VALUES ('$order_id', '$image_id')";
                if (!$conn->query($sql)) {
                    throw new Exception("Error inserting order items: " . $conn->error);
                }
            }

            // Clear user's cart
            $sql = "DELETE FROM cart WHERE user_id='$user_id'";
            if (!$conn->query($sql)) {
                throw new Exception("Error clearing cart: " . $conn->error);
            }

            // Commit transaction
            $conn->commit();
            echo "Purchase completed successfully.";
        } else {
            throw new Exception("Error inserting order: " . $conn->error);
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "Purchase failed: " . $e->getMessage();
    }
} else {
    echo "Your cart is empty.";
}

redirect('user/orders.php');
?>
