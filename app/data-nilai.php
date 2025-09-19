<?php
// Menghubungkan ke database
include '../auth/koneksi.php';
session_start();

// Ambil query pencarian jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'desc';  // Default 'desc' (dari terbesar)

// Query untuk mengambil data nilai siswa, termasuk kolom NEM, dan pencarian berdasarkan nama siswa
$query = $mysqli->prepare("
    SELECT tb_nilai.id_nilai, tb_siswa.nama, tb_nilai.bahasa_indonesia, tb_nilai.matematika, tb_nilai.ipa, tb_nilai.hasil, tb_nilai.nem
    FROM tb_nilai
    INNER JOIN tb_siswa ON tb_nilai.student_id = tb_siswa.student_id
    WHERE tb_siswa.nama LIKE ?
    ORDER BY tb_nilai.bahasa_indonesia $sortOrder, tb_nilai.matematika $sortOrder, tb_nilai.ipa $sortOrder, tb_nilai.hasil $sortOrder, tb_nilai.nem $sortOrder
");
$searchTerm = '%' . $search . '%';
$query->bind_param("s", $searchTerm);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nilai Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-4">
    <h3>Daftar Nilai Siswa</h3>
    
    <!-- Tombol Tambah Siswa -->
    <div class="mb-3">
        <a href="form-tambah-nilai.php" class="btn btn-primary">Tambah Nilai</a>
    </div>

    <!-- Form Pencarian -->
    <form method="GET" id="searchForm" class="mb-3" onsubmit="return false;">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama Siswa" value="<?php echo htmlspecialchars($search); ?>" id="searchInput">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary w-100" onclick="searchData()">Cari</button>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-secondary w-100" onclick="resetData()">Reset</button>
            </div>
        </div>

        <!-- Dropdown untuk memilih urutan pengurutan -->
        <div class="row mt-3">
            <div class="col-md-6">
                <select class="form-control" id="sortOrder" onchange="searchData()">
                    <option value="desc" <?php echo $sortOrder == 'desc' ? 'selected' : ''; ?>>Urutkan dari Terbesar</option>
                    <option value="asc" <?php echo $sortOrder == 'asc' ? 'selected' : ''; ?>>Urutkan dari Terkecil</option>
                </select>
            </div>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Bahasa Indonesia</th>
                <th>Matematika</th>
                <th>IPA</th>
                <th>Rata - rata</th>
                <th>NEM</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="nilaiTableBody">
        <?php
        $nomor = 1;
        while ($row = $result->fetch_assoc()) {
            // Menghitung NEM jika tidak tersedia
            $nem = isset($row['nem']) ? $row['nem'] : ($row['bahasa_indonesia'] + $row['matematika'] + $row['ipa']);
            echo "<tr id='row-{$row['id_nilai']}'>
                <td>{$nomor}</td>
                <td>" . htmlspecialchars($row['nama']) . "</td>
                <td>" . htmlspecialchars($row['bahasa_indonesia']) . "</td>
                <td>" . htmlspecialchars($row['matematika']) . "</td>
                <td>" . htmlspecialchars($row['ipa']) . "</td>
                <td>" . number_format($row['hasil'], 2) . "</td>
                <td>" . number_format($nem, 2) . "</td>
                <td>
                    <a href='javascript:void(0);' class='' onclick='editData({$row['id_nilai']})'>Edit</a> |
                    <a href='javascript:void(0);' class='' onclick='deleteData({$row['id_nilai']})'>Hapus</a>
                </td>
            </tr>";
            $nomor++;
        }
        ?>
        </tbody>
    </table>
</div>

<script>
    // Fungsi untuk menghapus data
    function deleteData(id_nilai) {
        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                url: 'hapus-data-nilai.php',
                type: 'GET',
                data: { id: id_nilai },
                success: function(response) {
                    if (response == 'success') {
                        alert('Data berhasil dihapus!');
                        $('#row-' + id_nilai).remove();
                    } else {
                        alert('Gagal menghapus data: ' + response);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan, silakan coba lagi!');
                }
            });
        }
    }

    // Fungsi untuk mengedit data
    function editData(id_nilai) {
        window.location.href = 'form-edit-nilai.php?id=' + id_nilai;
    }

    // Fungsi untuk melakukan pencarian menggunakan AJAX
    function searchData() {
        var searchQuery = $('#searchInput').val();
        var sortOrder = $('#sortOrder').val();  // Ambil nilai dari dropdown urutan

        $.ajax({
            url: 'home.php?page=data-nilai', // Pastikan URL ini mengarah ke halaman yang benar untuk memproses pencarian
            type: 'GET',
            data: { search: searchQuery, sortOrder: sortOrder },  // Sertakan parameter sortOrder
            success: function(response) {
                // Ambil bagian tabel nilai yang baru dari response
                var newTableContent = $(response).find('#nilaiTableBody').html();
                $('#nilaiTableBody').html(newTableContent);
            },
            error: function() {
                alert('Terjadi kesalahan, silakan coba lagi!');
            }
        });
    }

    // Fungsi untuk mereset data dan menampilkan kembali data lengkap
    function resetData() {
        $('#searchInput').val('');  // Kosongkan input pencarian
        searchData();  // Panggil fungsi pencarian untuk menampilkan data lengkap
    }

    // Fungsi untuk mencegah pencarian otomatis saat mengetik
    $(document).ready(function() {
        // Jangan jalankan pencarian otomatis, hanya tombol "Cari" yang memicu pencarian
    });
</script>
</body>
</html>