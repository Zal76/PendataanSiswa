<?php
// Menghubungkan ke database
include '../auth/koneksi.php';

// Ambil filter jika ada
$nilai_min = isset($_GET['nilai_min']) ? $_GET['nilai_min'] : '';
$nilai_max = isset($_GET['nilai_max']) ? $_GET['nilai_max'] : '';
$nem_min = isset($_GET['nem_min']) ? $_GET['nem_min'] : '';
$nem_max = isset($_GET['nem_max']) ? $_GET['nem_max'] : '';

// Ambil rentang nilai dan NEM dari dropdown
$nilai_range = isset($_GET['nilai_range']) ? $_GET['nilai_range'] : '';
$nem_range = isset($_GET['nem_range']) ? $_GET['nem_range'] : '';
$custom_nilai = isset($_GET['custom_nilai']) ? $_GET['custom_nilai'] : '';
$custom_nem = isset($_GET['custom_nem']) ? $_GET['custom_nem'] : '';

// Mulai membuat query dengan kondisi filter
$query = "SELECT tb_nilai.*, tb_siswa.nama 
          FROM tb_nilai 
          INNER JOIN tb_siswa ON tb_nilai.student_id = tb_siswa.student_id
          WHERE 1";  // WHERE 1 memungkinkan kita menambah kondisi filter

// Menambahkan kondisi filter untuk nilai rata-rata jika ada input nilai_range
if ($nilai_range !== '') {
    if ($nilai_range === 'custom' && $custom_nilai !== '') {
        $nilai_parts = explode('-', $custom_nilai);
        if (count($nilai_parts) == 2) {
            list($nilai_min, $nilai_max) = $nilai_parts;
            $query .= " AND tb_nilai.hasil BETWEEN " . (float) mysqli_real_escape_string($mysqli, $nilai_min) . " AND " . (float) mysqli_real_escape_string($mysqli, $nilai_max);
        } else {
            // Menangani kesalahan jika rentang nilai tidak valid
            echo "Rentang nilai tidak valid.";
        }
    } else {
        $nilai_parts = explode('-', $nilai_range);
        if (count($nilai_parts) == 2) {
            list($nilai_min, $nilai_max) = $nilai_parts;
            $query .= " AND tb_nilai.hasil BETWEEN " . (float) mysqli_real_escape_string($mysqli, $nilai_min) . " AND " . (float) mysqli_real_escape_string($mysqli, $nilai_max);
        } else {
            // Menangani kesalahan jika rentang nilai tidak valid
            echo "Rentang nilai tidak valid.";
        }
    }
}

// Menambahkan kondisi filter untuk NEM jika ada input nem_range
if ($nem_range !== '') {
    if ($nem_range === 'custom' && $custom_nem !== '') {
        $nem_parts = explode('-', $custom_nem);
        if (count($nem_parts) == 2) {
            list($nem_min, $nem_max) = $nem_parts;
            $query .= " AND tb_nilai.nem BETWEEN " . (float) mysqli_real_escape_string($mysqli, $nem_min) . " AND " . (float) mysqli_real_escape_string($mysqli, $nem_max);
        } else {
            // Menangani kesalahan jika rentang NEM tidak valid
            echo "Rentang NEM tidak valid.";
        }
    } else {
        $nem_parts = explode('-', $nem_range);
        if (count($nem_parts) == 2) {
            list($nem_min, $nem_max) = $nem_parts;
            $query .= " AND tb_nilai.nem BETWEEN " . (float) mysqli_real_escape_string($mysqli, $nem_min) . " AND " . (float) mysqli_real_escape_string($mysqli, $nem_max);
        } else {
            // Menangani kesalahan jika rentang NEM tidak valid
            echo "Rentang NEM tidak valid.";
        }
    }
}

// Eksekusi query
$result = mysqli_query($mysqli, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Nilai Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <!-- Form Filter -->
        <h2>Filter Data Nilai Siswa</h2>
        <form method="GET" action="home.php" onsubmit="return validateForm()">
            <input type="hidden" name="page" value="pelaporan">
            <div class="row align-items-end">
                <!-- Dropdown Rentang Nilai Rata-rata -->
                <div class="col-md-3">
                    <label for="nilai_range" class="form-label">Rentang Nilai Rata-rata</label>
                    <select name="nilai_range" id="nilai_range" class="form-control" onchange="toggleCustomRange()">
                        <option value="">Pilih Rentang Nilai</option>
                        <option value="1.00-2.00" <?php echo (isset($_GET['nilai_range']) && $_GET['nilai_range'] == '1.00-2.00') ? 'selected' : ''; ?>>1.00 - 2.00</option>
                        <option value="2.00-3.00" <?php echo (isset($_GET['nilai_range']) && $_GET['nilai_range'] == '2.00-3.00') ? 'selected' : ''; ?>>2.00 - 3.00</option>
                        <option value="4.00-5.00" <?php echo (isset($_GET['nilai_range']) && $_GET['nilai_range'] == '4.00-5.00') ? 'selected' : ''; ?>>4.00 - 5.00</option>
                        <option value="5.00-6.00" <?php echo (isset($_GET['nilai_range']) && $_GET['nilai_range'] == '5.00-6.00') ? 'selected' : ''; ?>>5.00 - 6.00</option>
                        <option value="6.00-7.00" <?php echo (isset($_GET['nilai_range']) && $_GET['nilai_range'] == '6.00-7.00') ? 'selected' : ''; ?>>6.00 - 7.00</option>
                        <option value="8.00-9.00" <?php echo (isset($_GET['nilai_range']) && $_GET['nilai_range'] == '8.00-9.00') ? 'selected' : ''; ?>>8.00 - 9.00</option>
                        <option value="9.00-10.00" <?php echo (isset($_GET['nilai_range']) && $_GET['nilai_range'] == '9.00-10.00') ? 'selected' : ''; ?>>9.00 - 10.00</option>
                        <option value="custom" <?php echo (isset($_GET['nilai_range']) && $_GET['nilai_range'] == 'custom') ? 'selected' : ''; ?>>Rentang lainnya</option>
                    </select>
                    <!-- Input Rentang Kustom yang muncul jika "Rentang lainnya" dipilih -->
                    <div id="custom_range" style="display: <?php echo (isset($_GET['nilai_range']) && $_GET['nilai_range'] == 'custom') ? 'block' : 'none'; ?>;">
                        <label for="custom_nilai" class="form-label">Masukkan Rentang Nilai</label>
                        <input type="text" name="custom_nilai" id="custom_nilai" class="form-control" 
                               value="<?php echo isset($_GET['custom_nilai']) ? $_GET['custom_nilai'] : ''; ?>" placeholder="Contoh: 5.00-7.00">
                        <div id="error-message" style="color: red; display: none;">Input rentang nilai tidak sesuai format. Gunakan format: X.XX-X.XX</div>
                    </div>
                </div>

                <!-- Dropdown Rentang NEM -->
                <div class="col-md-3">
                    <label for="nem_range" class="form-label">Rentang NEM</label>
                    <select name="nem_range" id="nem_range" class="form-control" onchange="toggleCustomNemRange()">
                        <option value="">Pilih Rentang NEM</option>
                        <option value="00.00-10.00" <?php echo (isset($_GET['nem_range']) && $_GET['nem_range'] == '00.00-10.00') ? 'selected' : ''; ?>>00.00 - 10.00</option>
                        <option value="10.00-20.00" <?php echo (isset($_GET['nem_range']) && $_GET['nem_range'] == '10.00-20.00') ? 'selected' : ''; ?>>10.00 - 20.00</option>
                        <option value="20.00-30.00" <?php echo (isset($_GET['nem_range']) && $_GET['nem_range'] == '20.00-30.00') ? 'selected' : ''; ?>>20.00 - 30.00</option>
                        <option value="custom" <?php echo (isset($_GET['nem_range']) && $_GET['nem_range'] == 'custom') ? 'selected' : ''; ?>>Rentang lainnya</option>
                    </select>
                    <!-- Input Rentang Kustom NEM -->
                    <div id="custom_nem_range" style="display: <?php echo (isset($_GET['nem_range']) && $_GET['nem_range'] == 'custom') ? 'block' : 'none'; ?>;">
                        <label for="custom_nem" class="form-label">Masukkan Rentang NEM</label>
                        <input type="text" name="custom_nem" id="custom_nem" class="form-control" 
                               value="<?php echo isset($_GET['custom_nem']) ? $_GET['custom_nem'] : ''; ?>" placeholder="Contoh: 10.00-20.00">
                        <div id="error-nem-message" style="color: red; display: none;">Input rentang NEM tidak sesuai format. Gunakan format: X.XX-X.XX</div>
                    </div>
                </div>

                <!-- Input Filter untuk Nilai Rata-Rata dan NEM -->
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter Data</button>
                </div>

                <!-- Tombol Reset Filter -->
                <div class="col-md-3">
                    <a href="home.php?page=pelaporan" class="btn btn-secondary w-100">Reset Filter</a>
                </div>
            </div>
        </form>

        <h2 class="mt-4">Daftar Nilai Siswa</h2>

        <?php
        // Cek apakah query mengembalikan data
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Bahasa Indonesia</th>
                            <th>Matematika</th>
                            <th>IPA</th>
                            <th>Rata-rata</th>
                            <th>NEM</th>
                        </tr>
                    </thead>
                    <tbody>';

            // Variabel untuk nomor urut
            $nomor = 1;

            // Menampilkan data dalam tabel
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$nomor}</td> <!-- Nomor urut -->
                        <td>" . htmlspecialchars($row['nama']) . "</td>
                        <td>" . htmlspecialchars($row['bahasa_indonesia']) . "</td>
                        <td>" . htmlspecialchars($row['matematika']) . "</td>
                        <td>" . htmlspecialchars($row['ipa']) . "</td>
                        <td>" . number_format($row['hasil'], 2) . "</td>
                        <td>" . number_format($row['nem'], 2) . "</td>
                      </tr>";

                // Increment nomor urut
                $nomor++;
            }
            echo '</tbody></table>';
        } else {
            // Menampilkan pesan jika tidak ada data yang ditemukan
            echo '<p class="text-center">Data tidak ditemukan dengan filter yang diberikan.</p>';
        }
        ?>

    </div>

    <script>
        // Fungsi untuk menampilkan atau menyembunyikan input rentang kustom
        function toggleCustomRange() {
            var nilaiRange = document.getElementById("nilai_range").value;
            var customRangeDiv = document.getElementById("custom_range");
            if (nilaiRange == "custom") {
                customRangeDiv.style.display = "block";
            } else {
                customRangeDiv.style.display = "none";
            }
        }

        // Fungsi untuk menampilkan atau menyembunyikan input rentang kustom NEM
        function toggleCustomNemRange() {
            var nemRange = document.getElementById("nem_range").value;
            var customNemRangeDiv = document.getElementById("custom_nem_range");
            if (nemRange == "custom") {
                customNemRangeDiv.style.display = "block";
            } else {
                customNemRangeDiv.style.display = "none";
            }
        }

        // Validasi form untuk memastikan rentang nilai kustom valid
        function validateForm() {
            var customNilai = document.getElementById("custom_nilai").value.trim(); // Menghapus spasi ekstra di awal dan akhir
            var errorMessage = document.getElementById("error-message");
            var regex = /^[0-9]+(\.[0-9]{2})?\s*-\s*[0-9]+(\.[0-9]{2})?$/; // Format X.XX - X.XX dengan spasi yang diperbolehkan di sekitar tanda minus

            if (customNilai && !regex.test(customNilai)) {
                errorMessage.style.display = "block";
                return false; // Menghentikan pengiriman form
            } else {
                errorMessage.style.display = "none";
            }

            var customNem = document.getElementById("custom_nem").value.trim(); // Menghapus spasi ekstra di awal dan akhir
            var errorNemMessage = document.getElementById("error-nem-message");
            if (customNem && !regex.test(customNem)) {
                errorNemMessage.style.display = "block";
                return false; // Menghentikan pengiriman form
            } else {
                errorNemMessage.style.display = "none";
            }

            return true; // Melanjutkan pengiriman form
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
