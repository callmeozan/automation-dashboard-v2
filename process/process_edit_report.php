<?php
include '../config.php';

// 1. Tangkap Data dari Form
$id = $_POST['report_id'];
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
$problem = mysqli_real_escape_string($conn, $_POST['problem']);
$action = mysqli_real_escape_string($conn, $_POST['action']);
$sparepart_used = mysqli_real_escape_string($conn, $_POST['sparepart_used']);
$status = $_POST['status']; // Tangkap status baru (Open/Monitor/Solved)

// 2. Hitung Ulang Total Downtime (Jika jam berubah)
$total_downtime_minutes = 0;
if (!empty($time_start) && !empty($time_finish)) {
    $start = strtotime($time_start);
    $end = strtotime($time_finish);
    if ($end < $start) {
        $end += 24 * 60 * 60;
    } // Handle lewat tengah malam
    $diff = $end - $start;
    $total_downtime_minutes = floor($diff / 60);
}

// 3. Handle Upload Evidence Baru (Opsional)
$file_query = "";
if (!empty($_FILES['evidence']['name'])) {
    $target_dir = "../uploads/";
    $file_name = "EVID_" . time() . "_REV_" . basename($_FILES["evidence"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["evidence"]["tmp_name"], $target_file)) {
        // Jika sukses upload, tambahkan ke query update
        $file_query = ", evidence_file = '$file_name'";

        // (Opsional: Hapus file lama bisa ditambahkan di sini)
    }
}

// 4. Query Update
$query = "UPDATE tb_daily_reports SET 
            date_log = '$date_log',
            end_date = '$end_date',
            plant = '$plant',
            shift = '$shift',
            time_start = '$time_start',
            time_finish = '$time_finish',
            total_downtime_minutes = '$total_downtime_minutes',
            pic = '$pic',
            machine_name = '$machine_name',
            category = '$category',
            problem = '$problem',
            action = '$action',
            sparepart_used = '$sparepart_used',
            status = '$status'
            $file_query
          WHERE report_id = '$id'";

if (mysqli_query($conn, $query)) {
    header("Location: ../laporan.php?status=updated");
} else {
    $error = urlencode(mysqli_error($conn));
    header("Location: ../laporan.php?status=error&msg=$error");
}
