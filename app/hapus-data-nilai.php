<?php
// Memulai session untuk menangani pesan flash
session_start();

// Pastikan ada id_nilai yang dikirim melalui URL
if (isset($_GET['id'])) {
    // Mengambil nilai id_nilai dari parameter URL
    $id_nilai = $_GET['id'];

    // Menghubungkan ke database
    include '../auth/koneksi.php';

    // Menggunakan prepared statement untuk menghapus data nilai berdasarkan id_nilai
    $stmt = $mysqli->prepare("DELETE FROM tb_nilai WHERE id_nilai = ?");
    $stmt->bind_param("i", $id_nilai); // "i" untuk integer

    // Menjalankan query untuk menghapus data
    if ($stmt->execute()) {
        // Mengirimkan respons sukses ke AJAX
        echo 'success';
    } else {
        // Mengirimkan pesan error jika terjadi masalah
        echo 'error';
    }

    // Menutup prepared statement
    $stmt->close();
} else {
    // Jika id_nilai tidak ditemukan
    echo 'error';
}
?>
