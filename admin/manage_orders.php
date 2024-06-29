<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    redirect('../index.php');
}

// Fetch all orders from database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders
</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="dashboard.php"><i class="fas fa-home"></i> Admin</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li> -->
                <li class="nav-item"><a class="nav-link" href="manage_users.php"><i class="fas fa-users"></i> Users</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_approve.php"><i class="fas fa-check"></i> Approve Images</a></li>
                <li class="nav-item"><a class="nav-link" href="manage_orders.php"><i class="fas fa-box"></i> Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center">Orders
</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-info text-center'>{$_SESSION['message']}</div>";
            unset($_SESSION['message']);
        }
        ?>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Details</th>
                    <th>Total Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['order_id']}</td>";
                        echo "<td>{$row['user_id']}</td>";
                        echo "<td>{$row['details']}</td>";
                        echo "<td>{$row['total_price']}</td>";
                        echo "<td>{$row['created_at']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
