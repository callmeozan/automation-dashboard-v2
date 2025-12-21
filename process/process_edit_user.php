<?php
session_start();
include '../config.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

// 1. Tangkap Data
$user_id    = $_POST['user_id'];
$full_name  = mysqli_real_escape_string($conn, $_POST['full_name']);
$short_name = mysqli_real_escape_string($conn, $_POST['short_name']);
$role       = $_POST['role'];

// 2. Update Database (Password & Username tidak diubah disini)
$query = "UPDATE tb_users SET 
            full_name = '$full_name',
            short_name = '$short_name',
            role = '$role'
          WHERE user_id = '$user_id'";

if (mysqli_query($conn, $query)) {
    header("Location: ../manage_users.php?status=updated");
} else {
    $error = urlencode(mysqli_error($conn));
    header("Location: ../manage_users.php?status=error&msg=$error");
}
?>