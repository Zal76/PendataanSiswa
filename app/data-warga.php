<?php
session_start(); // Pastikan session dijalankan
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Warga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h3>Daftar Warga Baru</h3>

    <!-- Notifikasi -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']); // Hapus pesan setelah ditampilkan
            ?>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']); // Hapus pesan setelah ditampilkan
            ?>
        </div>
    <?php endif; ?>

    <a href="form-tambah.php" class="btn btn-primary mb-3">Tambah Warga</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>Pekerjaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../auth/koneksi.php';
            $query = mysqli_query($mysqli, "SELECT warga.*, pekerjaan.nama_pekerjaan FROM warga 
                                            JOIN pekerjaan ON warga.id_pekerjaan = pekerjaan.id_pekerjaan");

            $nomor = 1; // Inisialisasi nomor urut
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>
                        <td>{$nomor}</td> <!-- Nomor urut -->
                        <td>{$row['nama_lengkap']}</td>
                        <td>{$row['tanggal_lahir']}</td>
                        <td>{$row['alamat']}</td>
                        <td>{$row['nomor_telepon']}</td>
                        <td>{$row['nama_pekerjaan']}</td>
                        <td>
                            <a href='form-edit.php?id={$row['id_warga']}'>Edit | </a> 
                            <a href='hapus-data.php?id={$row['id_warga']}' 
                            onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                        </td>
                    </tr>";
                $nomor++; // Increment nomor urut
            }
            ?>
        </tbody>
     </table>
</div>
</body>
</html>
