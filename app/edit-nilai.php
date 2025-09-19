<?php
session_start();
include '../auth/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_nilai = $_POST['id_nilai'];
    $bahasa_indonesia = $_POST['bahasa_indonesia'];
    $matematika = $_POST['matematika'];
    $ipa = $_POST['ipa'];

    // Logika untuk hasil dan NEM
    if ($bahasa_indonesia == 10.0 && $matematika == 10.0 && $ipa == 10.0) {
        // Jika semua nilai adalah 10.0, hasil menjadi 30.0
        $hasil = 30.0;
    } else {
        // Jika tidak, hitung rata-rata
        $hasil = ($bahasa_indonesia + $matematika + $ipa) / 3;
    }

    // Hitung total nilai untuk kolom NEM
    $nem = $bahasa_indonesia + $matematika + $ipa;

    // Query untuk update data nilai
    $stmt = $mysqli->prepare("UPDATE tb_nilai 
                              SET bahasa_indonesia = ?, matematika = ?, ipa = ?, hasil = ?, nem = ? 
                              WHERE id_nilai = ?");

    // Bind parameter: d (double) untuk nilai, i (integer) untuk id_nilai
    $stmt->bind_param("dddddi", $bahasa_indonesia, $matematika, $ipa, $hasil, $nem, $id_nilai);

    // Eksekusi query
    if ($stmt->execute()) {
        $_SESSION['success'] = "Data nilai berhasil diperbarui dengan hasil: $hasil dan NEM: $nem.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui data nilai: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();

    // Redirect kembali ke halaman daftar nilai
    header("Location: home.php?page=data-nilai");
    exit;
}
?>
