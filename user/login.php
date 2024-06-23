<?php
session_start();
include_once '../includes/db.php';
include_once '../includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $username = sanitize_input($_POST['username']);
    $password = $_POST['password'];

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (verify_password($password, $row['password'])) {
            // Login successful
            $_SESSION['user_id'] = $row['id'];
            redirect('dashboard.php');
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>
<!-- HTML form for login -->
<form method="post">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
