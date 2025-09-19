<?php
// Memulai session untuk menangani pesan flash
session_start();

// Pastikan ada id_warga yang dikirim melalui URL
if (isset($_GET['id'])) {
    // Mengambil nilai id_warga dari parameter URL
    $student_id = $_GET['id'];

    // Menghubungkan ke database
    include '../auth/koneksi.php';

    // Menggunakan prepared statement untuk menghapus data warga berdasarkan id_warga
    $stmt = $mysqli->prepare("DELETE FROM tb_siswa WHERE student_id = ?");
    $stmt->bind_param("i", $student_id); // "i" untuk integer

    // Menjalankan query untuk menghapus data warga
    if ($stmt->execute()) {
        // Set pesan sukses jika berhasil menghapus data
        $_SESSION['success'] = "Data berhasil dihapus.";
    } else {
        // Set pesan error jika gagal menghapus data
        $_SESSION['error'] = "Gagal menghapus data: " . $stmt->error;
    }

    // Menutup prepared statement
    $stmt->close();
} else {
    // Jika id_warga tidak ditemukan
    $_SESSION['error'] = "ID tidak ditemukan.";
}

// Redirect kembali ke halaman daftar warga (home.php)
header('Location: home.php');
exit;
?>