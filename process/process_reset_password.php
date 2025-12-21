<?php
session_start();
include '../config.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

$id = $_GET['id'];
$default_password = md5('123456'); // Password Default: 123456

// Update Password
$query = "UPDATE tb_users SET password = '$default_password' WHERE user_id = '$id'";

if (mysqli_query($conn, $query)) {
    header("Location: ../manage_users.php?status=success&msg=Password berhasil direset menjadi 123456");
} else {
    $error = urlencode(mysqli_error($conn));
    header("Location: ../manage_users.php?status=error&msg=$error");
}
?>