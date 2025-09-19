<?php
session_start(); // Pastikan hanya sekali dipanggil
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h3>Daftar Siswa</h3>

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

    <!-- Form Filter -->
    <form method="GET" class="mb-3">
    <div class="form-row">
        <div class="col">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki" <?= isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= isset($_GET['jenis_kelamin']) && $_GET['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>
        <div class="col">
            <label for="agama">Agama</label>
            <select name="agama" class="form-control">
                <option value="">-- Pilih Agama --</option>
                <option value="Islam" <?= isset($_GET['agama']) && $_GET['agama'] == 'Islam' ? 'selected' : '' ?>>Islam</option>
                <option value="Kristen" <?= isset($_GET['agama']) && $_GET['agama'] == 'Kristen' ? 'selected' : '' ?>>Kristen</option>
                <option value="Hindu" <?= isset($_GET['agama']) && $_GET['agama'] == 'Hindu' ? 'selected' : '' ?>>Hindu</option>
                <option value="Budha" <?= isset($_GET['agama']) && $_GET['agama'] == 'Budha' ? 'selected' : '' ?>>Budha</option>
            </select>
        </div>
        <div class="col">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" class="form-control" placeholder="Cari Alamat" value="<?= isset($_GET['alamat']) ? $_GET['alamat'] : '' ?>">
        </div>
        <div class="col mt-4">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>


    <a href="form-tambah-siswa.php" class="btn btn-primary mb-3">Tambah Siswa</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <?php
            // Fungsi untuk membuat link sorting
            function sort_link($field, $label) {
                $current_sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                $current_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
                $new_order = ($current_sort == $field && $current_order == 'ASC') ? 'DESC' : 'ASC';
                $arrow = '';

                if ($current_sort == $field) {
                    $arrow = $current_order == 'ASC' ? '▲' : '▼';
                }

                return "<a href='?sort=$field&order=$new_order'>$label $arrow</a>";
            }
            ?>
            <th>No</th>
            <th style="color: black;"><?= sort_link('nama', 'Nama Siswa') ?></th>
            <th style="color: black;"><?= sort_link('nomor_induk', 'Nomor Induk') ?></th>
            <th style="color: black;"><?= sort_link('jenis_kelamin', 'Jenis Kelamin') ?></th>
            <th style="color: black;"><?= sort_link('agama', 'Agama') ?></th>
            <th style="color: black;"><?= sort_link('alamat', 'Alamat') ?></th>

            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
<?php
include '../auth/koneksi.php';

// Ambil filter dari GET
$jenis_kelamin = isset($_GET['jenis_kelamin']) ? $_GET['jenis_kelamin'] : '';
$agama = isset($_GET['agama']) ? $_GET['agama'] : '';
$alamat = isset($_GET['alamat']) ? $_GET['alamat'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'nama';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Query dengan klausa WHERE dan ORDER BY
$query = "SELECT student_id, nama, nomor_induk, jenis_kelamin, agama, alamat FROM tb_siswa WHERE 1=1";

if ($jenis_kelamin != '') {
    $query .= " AND jenis_kelamin = '$jenis_kelamin'";
}
if ($agama != '') {
    $query .= " AND agama = '$agama'";
}
if ($alamat != '') {
    $query .= " AND alamat LIKE '%$alamat%'";
}

$query .= " ORDER BY $sort $order";

$result = mysqli_query($mysqli, $query);

// Cek apakah ada data yang ditemukan
if (mysqli_num_rows($result) > 0) {
    $nomor = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$nomor}</td>
            <td>{$row['nama']}</td>
            <td>{$row['nomor_induk']}</td>
            <td>{$row['jenis_kelamin']}</td>
            <td>{$row['agama']}</td>
            <td>{$row['alamat']}</td>
            <td>
                <a href='form-edit-siswa.php?id={$row['student_id']}'>Edit</a> |
                <a href='hapus-data-siswa.php?id={$row['student_id']}' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
            </td>
        </tr>";
        $nomor++;
    }
} else {
    // Tampilkan pesan jika tidak ada data yang ditemukan
    echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan</td></tr>";
}
?>
</tbody>
    </table>
</div>
</body>
</html>