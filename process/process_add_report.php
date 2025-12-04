<?php
include '../config.php';

// 1. Tangkap Data
$date_log = $_POST['date_log'];
$end_date = $_POST['end_date'];
$plant = $_POST['plant'];
$shift = $_POST['shift'];
$time_start = $_POST['time_start'];
$time_finish = $_POST['time_finish'];
// $pic = $_POST['pic'];
// Handle PIC Multi-Select
if (isset($_POST['pic'])) {
    if (is_array($_POST['pic'])) {
        $pic_string = implode(", ", $_POST['pic']); // Gabung array jadi "Budi, Andi"
    } else {
        $pic_string = $_POST['pic'];
    }
} else {
    $pic_string = "";
}
$pic = mysqli_real_escape_string($conn, $pic_string);
$machine_name = $_POST['machine_name'];
$category = $_POST['category'];
$problem = mysqli_real_escape_string($conn, $_POST['problem']); // Cegah error tanda kutip
$action = mysqli_real_escape_string($conn, $_POST['action']);
$sparepart_used = mysqli_real_escape_string($conn, $_POST['sparepart_used']);
$status = 'Solved'; // Default status

// 2. Hitung Total Downtime (Menit) secara Otomatis
$total_downtime_minutes = 0;
if(!empty($time_start) && !empty($time_finish)){
    $start = strtotime($time_start);
    $end = strtotime($time_finish);
    
    // Jika finish lebih kecil dari start (lewat tengah malam), tambah 24 jam
    if($end < $start) {
        $end += 24 * 60 * 60;
    }
    
    $diff = $end - $start;
    $total_downtime_minutes = floor($diff / 60);
}

// 3. Handle Upload Evidence
$evidence_file = "";
if(!empty($_FILES['evidence']['name'])){
    $target_dir = "../uploads/";
    $file_name = "EVID_" . time() . "_" . basename($_FILES["evidence"]["name"]);
    $target_file = $target_dir . $file_name;
    
    if (move_uploaded_file($_FILES["evidence"]["tmp_name"], $target_file)) {
        $evidence_file = $file_name;
    }
}

// 4. Simpan ke Database
$query = "INSERT INTO tb_daily_reports (
    date_log, end_date, plant, shift, time_start, time_finish, total_downtime_minutes,
    pic, machine_name, category, problem, action, sparepart_used, status, evidence_file
) VALUES (
    '$date_log', '$end_date', '$plant', '$shift', '$time_start', '$time_finish', '$total_downtime_minutes',
    '$pic', '$machine_name', '$category', '$problem', '$action', '$sparepart_used', '$status', '$evidence_file'
)";

if (mysqli_query($conn, $query)) {
    header("Location: ../laporan.php?status=success");
} else {
    $error = urlencode(mysqli_error($conn));
    header("Location: ../laporan.php?status=error&msg=$error");
}
?>