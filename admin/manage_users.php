<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/function.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    redirect('../index.php');
}

// Fetch all users from database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
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
        <h1 class="text-center">Users</h1>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-info text-center'>{$_SESSION['message']}</div>";
            unset($_SESSION['message']);
        }
        ?>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['username']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['created_at']}</td>"; // Display the creation date
                        echo "<td><button class='btn btn-danger btn-sm' onclick='confirmDelete({$row['id']})'><i class='fas fa-trash'></i> Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <br>
        <!-- <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a> -->
    </div>
    
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a id="deleteButton" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function confirmDelete(userId) {
            $('#confirmDeleteModal').modal('show');
            document.getElementById('deleteButton').setAttribute('href', 'delete_user.php?id=' + userId);
        }
    </script>
</body>
</html>
