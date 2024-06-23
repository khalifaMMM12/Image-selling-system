<?php

// Include database connection
include_once 'db.php';

// Function to sanitize user input
function sanitize_input($input) {
    global $conn;
    return mysqli_real_escape_string($conn, $input);
}

// Function to hash password
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify hashed password
function verify_password($password, $hashed_password) {
    return password_verify($password, $hashed_password);
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to redirect user
function redirect($url) {
    header("Location: $url");
    exit();
}
