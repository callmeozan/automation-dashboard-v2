<?php
session_start();
include '../config.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../dashboard.php");
    exit();
}

$id = $_GET['id'];

// Cegah hapus diri sendiri
if ($id == $_SESSION['user_id']) {
    header("Location: ../manage_users.php?status=error&msg=Tidak bisa menghapus akun sendiri!");
    exit();
}

// Cegah hapus akun 'admin' utama (username 'admin')
$cekAdmin = mysqli_query($conn, "SELECT username FROM tb_users WHERE user_id='$id'");
$dAdmin = mysqli_fetch_assoc($cekAdmin);
if($dAdmin['username'] == 'admin'){
     header("Location: ../manage_users.php?status=error&msg=Akun Super Admin tidak boleh dihapus!");
     exit();
}

// Hapus Data
$query = "DELETE FROM tb_users WHERE user_id = '$id'";

if (mysqli_query($conn, $query)) {
    header("Location: ../manage_users.php?status=deleted");
} else {
    $error = urlencode(mysqli_error($conn));
    header("Location: ../manage_users.php?status=error&msg=$error");
}
?>