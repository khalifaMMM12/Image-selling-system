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
    $username = sanitize_input($_POST['username'] ); 
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <br>
        <button type="submit">Login</button>
        <?php if ($login_error_message): ?>
            <p><?php echo $login_error_message; ?></p>
        <?php endif; ?>
    </form>
    <p>Don't have an account? <a href="user/register.php">Register here</a></p>
</body>
</html>
