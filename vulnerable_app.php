<?php
// ===============================
// INTENTIONALLY VULNERABLE FILE
// ===============================

// Hardcoded credentials (Sensitive Data Exposure)
$db_host = "localhost";
$db_user = "root";
$db_pass = "password123";
$db_name = "testdb";

// Database connection (no error handling)
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// -------------------------------
// SQL Injection Vulnerability
// -------------------------------
$username = $_GET['username'];
$password = $_GET['password'];

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

// -------------------------------
// Cross-Site Scripting (XSS)
// -------------------------------
if (isset($_GET['comment'])) {
    echo "User Comment: " . $_GET['comment'];
}

// -------------------------------
// Command Injection
// -------------------------------
if (isset($_GET['ip'])) {
    $ip = $_GET['ip'];
    system("ping -c 2 " . $ip);
}

// -------------------------------
// File Inclusion Vulnerability
// -------------------------------
if (isset($_GET['page'])) {
    include($_GET['page']);
}

// -------------------------------
// Insecure File Upload
// -------------------------------
if (isset($_FILES['file'])) {
    move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $_FILES['file']['name']);
    echo "File uploaded successfully!";
}

// -------------------------------
// Weak Session Management
// -------------------------------
session_start();
$_SESSION['user'] = $username;

// -------------------------------
// No CSRF Protection
// -------------------------------
if (isset($_POST['delete'])) {
    mysqli_query($conn, "DELETE FROM users");
    echo "All users deleted!";
}

?>
