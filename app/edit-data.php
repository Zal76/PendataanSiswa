<?php
// Mulai session untuk menangani pesan flash
session_start();

// Menghubungkan ke database
include '../auth/koneksi.php';

// Pastikan ada id yang diterima dari URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Query untuk mengambil data siswa berdasarkan student_id
    $stmt = $mysqli->prepare("SELECT * FROM tb_siswa WHERE student_id = ?");
    $stmt->bind_param("i", $student_id); // Mengikat parameter sebagai integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Memastikan data ditemukan
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc(); // Menyimpan data siswa ke dalam variabel $data
    } else {
        // Jika data tidak ditemukan, redirect ke halaman lain dan set pesan error
        $_SESSION['error'] = "Data siswa tidak ditemukan!";
        header("Location: home.php?page=data-siswa");
        exit;
    }
} else {
    // Jika id tidak ada di URL, redirect dengan pesan error
    $_SESSION['error'] = "ID siswa tidak valid!";
    header("Location: home.php?page=data-siswa");
    exit;
}
?>
