<?php
include '../auth/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input dari form
    $nama = mysqli_real_escape_string($mysqli, $_POST['nama']);
    $nomor_induk = mysqli_real_escape_string($mysqli, $_POST['nomor_induk']);
    $jenis_kelamin = mysqli_real_escape_string($mysqli, $_POST['jenis_kelamin']);
    $agama = mysqli_real_escape_string($mysqli, $_POST['agama']);
    $alamat = mysqli_real_escape_string($mysqli, $_POST['alamat']);

    // Cek apakah nomor induk sudah ada di database
    $check_query = "SELECT * FROM tb_siswa WHERE nomor_induk = '$nomor_induk'";
    $result = mysqli_query($mysqli, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // Jika nomor induk sudah ada
        session_start();
        $_SESSION['error'] = "Nomor induk sudah terdaftar. Silakan masukkan nomor induk yang lain.";
        header("Location: form-tambah-siswa.php");
        exit;
    }

    // Query INSERT untuk menambahkan data ke tb_siswa
    $query = "INSERT INTO tb_siswa (nama, nomor_induk, jenis_kelamin, agama, alamat) 
              VALUES ('$nama', '$nomor_induk', '$jenis_kelamin', '$agama', '$alamat')";

    session_start();
    if (mysqli_query($mysqli, $query)) {
        $_SESSION['success'] = "Data siswa berhasil ditambahkan.";
        header("Location: home.php?page=data-siswa");
        exit;
    } else {
        $_SESSION['error'] = "Gagal menambahkan data siswa: " . mysqli_error($mysqli);
        header("Location: form-tambah-siswa.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa</title>
</head>
<body>
    <!-- Menampilkan pesan error jika ada -->
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
        <label>Nama Siswa:</label>
        <input type="text" name="nama" required>
        <br>
        <label>Nomor Induk:</label>
        <input type="text" name="nomor_induk" required>
        <br>
        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
        <br>
        <label>Agama:</label>
        <select name="agama" required>
            <option value="islam">Islam</option>
            <option value="kristen">Kristen</option>
            <option value="buddha">Buddha</option>
            <option value="hindu">Hindu</option>
            <option value="konghuchu">Konghuchu</option>
        </select>
        <br>
        <label>Alamat:</label>
        <textarea name="alamat" required></textarea>
        <br>
        <button type="submit">Tambah</button>
    </form>
</body>
</html>
