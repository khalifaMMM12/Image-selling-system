<?php
session_start();
include_once 'includes/db.php';
include_once 'includes/function.php';

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    redirect('admin/dashboard.php');
} elseif (isset($_SESSION['user_id'])) {
    redirect('user/dashboard.php');
}

$login_error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username']); 
    $password = sanitize_input($_POST['password']);
    $role = sanitize_input($_POST['role']);

    if ($role == 'admin') {
        $sql = "SELECT * FROM admins WHERE username='$username'";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            if ($role == 'admin') {
                $_SESSION['admin_id'] = $user['id'];
                redirect('admin/admin_approve.php');
            } else {
                $_SESSION['user_id'] = $user['id'];
                redirect('user/dashboard.php');
            }
        } else {
            $login_error_message = 'Invalid password.';
        }
    } else {
        $login_error_message = 'No user found with that username.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h1>Login</h1>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select id="role" name="role" class="form-control" required>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                            <?php if ($login_error_message): ?>
                                <div class="alert alert-danger mt-3">
                                    <?php echo $login_error_message; ?>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Don't have an account? <a href="user/register.php">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
