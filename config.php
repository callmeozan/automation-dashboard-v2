<?php
// Setting Waktu Indonesia Barat (WIB)
date_default_timezone_set('Asia/Jakarta');
$host = "localhost";
$user = "root";
$pass = "";
$db   = "automation_dashboard"; // Pastikan nama database di phpMyAdmin sama persis

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

// ==========================================
// FITUR MAINTENANCE MODE (SAKLAR)
// ==========================================
$maintenance_mode = false; // Ganti jadi TRUE untuk mengaktifkan maintenance

if ($maintenance_mode) {
    // Cek halaman apa yang sedang dibuka sekarang
    $current_page = basename($_SERVER['PHP_SELF']);

    // Kecualikan halaman login admin khusus (opsional) atau file itu sendiri
    // Tapi karena services.html itu HTML (bukan PHP), dia aman.

    // Redirect semua orang ke services.html
    header("Location: services.html");
    exit();
}
