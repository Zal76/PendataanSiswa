<?php
session_start();

// Pastikan koneksi ke database dilakukan
include '../auth/koneksi.php';

// Cek apakah ada parameter 'id' di URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Ambil data siswa berdasarkan student_id dari database
    $query = "SELECT student_id, nama, nomor_induk, jenis_kelamin, agama, alamat FROM tb_siswa WHERE student_id = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, 'i', $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Jika data ditemukan, masukkan ke dalam variabel
    if ($row = mysqli_fetch_assoc($result)) {
        $data = $row;
    } else {
        // Jika tidak ada data, redirect ke halaman data siswa
        $_SESSION['error'] = 'ID siswa tidak valid!';
        header('Location: home.php?page=data-siswa');
        exit;
    }
} else {
    // Jika tidak ada 'id', redirect ke halaman data siswa
    $_SESSION['error'] = 'ID siswa tidak ditemukan.';
    header('Location: home.php?page=data-siswa');
    exit;
}

// Jika form disubmit, lakukan update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $student_id = $_POST['student_id'];
    $nama = $_POST['nama'];
    $nomor_induk = $_POST['nomor_induk'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];

    // Query untuk update data siswa
    $update_query = "UPDATE tb_siswa SET nama = ?, nomor_induk = ?, jenis_kelamin = ?, agama = ?, alamat = ? WHERE student_id = ?";
    $stmt_update = mysqli_prepare($mysqli, $update_query);
    mysqli_stmt_bind_param($stmt_update, 'sssssi', $nama, $nomor_induk, $jenis_kelamin, $agama, $alamat, $student_id);

    if (mysqli_stmt_execute($stmt_update)) {
        // Jika update berhasil
        $_SESSION['success'] = 'Data siswa berhasil diperbarui!';
        header('Location: home.php?page=data-siswa');
        exit;
    } else {
        // Jika terjadi error saat update
        $_SESSION['error'] = 'Terjadi kesalahan saat memperbarui data!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h3>Edit Data Siswa</h3>

    <!-- Menampilkan pesan error atau sukses jika ada -->
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    ?>

    <form action="form-edit-siswa.php?id=<?php echo $student_id; ?>" method="POST" id="editForm">
        <!-- ID Siswa (tidak ditampilkan) -->
        <input type="hidden" name="student_id" value="<?php echo isset($data['student_id']) ? htmlspecialchars($data['student_id'], ENT_QUOTES, 'UTF-8') : ''; ?>">

        <!-- Nama -->
        <div class="form-group">
            <label for="inputNama">Nama</label>
            <input name="nama" type="text" class="form-control" id="inputNama" 
                   value="<?php echo isset($data['nama']) ? htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
                   placeholder="Masukkan nama" required>
        </div>

        <!-- Nomor Induk -->
        <div class="form-group">
            <label for="inputNomorInduk">Nomor Induk</label>
            <input type="text" name="nomor_induk" class="form-control" id="inputNomorInduk" 
                   value="<?php echo isset($data['nomor_induk']) ? htmlspecialchars($data['nomor_induk'], ENT_QUOTES, 'UTF-8') : ''; ?>" 
                   placeholder="Masukkan nomor induk" required>
        </div>

        <!-- Jenis Kelamin -->
        <div class="form-group">
            <label for="inputJenisKelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" id="inputJenisKelamin" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" <?php echo isset($data['jenis_kelamin']) && $data['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="Perempuan" <?php echo isset($data['jenis_kelamin']) && $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
            </select>
        </div>

        <!-- Agama -->
        <div class="form-group">
    <label for="inputAgama">Agama</label>
    <select name="agama" class="form-control" id="inputAgama" required>
        <option value="" disabled selected>Pilih Agama</option>
        <option value="Islam" <?php echo isset($data['agama']) && $data['agama'] == 'Islam' ? 'selected' : ''; ?>>Islam</option>
        <option value="Kristen" <?php echo isset($data['agama']) && $data['agama'] == 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
        <option value="Buddha" <?php echo isset($data['agama']) && $data['agama'] == 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
        <option value="Hindu" <?php echo isset($data['agama']) && $data['agama'] == 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
        <option value="Konghucu" <?php echo isset($data['agama']) && $data['agama'] == 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
    </select>
</div>


        <!-- Alamat -->
        <div class="form-group">
            <label for="inputAlamat">Alamat</label>
            <textarea name="alamat" class="form-control" id="inputAlamat" 
                      placeholder="Masukkan alamat" required><?php echo isset($data['alamat']) ? htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
        </div>

        <!-- Tombol Simpan dan Batal -->
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="home.php?page=data-siswa" class="btn btn-secondary ml-2">Batal</a>
    </form>
</div>
</body>
</html>
