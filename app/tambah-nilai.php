<?php
// Menghubungkan ke database
include '../auth/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $student_id = $_POST['student_id'];
    $bahasa_indonesia = $_POST['bahasa_indonesia'];
    $matematika = $_POST['matematika'];
    $ipa = $_POST['ipa'];

    // Menghitung nilai NEM
    $nem = $bahasa_indonesia + $matematika + $ipa;

    // Menyusun query untuk menyimpan data ke database
    $query = "INSERT INTO tb_nilai (student_id, bahasa_indonesia, matematika, ipa, hasil, nem)
              VALUES (?, ?, ?, ?, ?, ?)";
    
    // Menghitung rata-rata
    $hasil = ($bahasa_indonesia + $matematika + $ipa) / 3;

    // Persiapkan statement
    if ($stmt = $mysqli->prepare($query)) {
        // Bind parameter
        $stmt->bind_param("iiiiid", $student_id, $bahasa_indonesia, $matematika, $ipa, $hasil, $nem);

        // Eksekusi query
        if ($stmt->execute()) {
            // Redirect atau beri pesan sukses
            header("Location: home.php?page=data-nilai");
            exit();
        } else {
            echo "Gagal menyimpan data: " . $stmt->error;
        }
    } else {
        echo "Gagal mempersiapkan query: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Nilai Siswa</title>
</head>
<body>
    <form method="POST" action="tambah-nilai.php">
        <label>Siswa:</label>
        <select name="student_id">
            <?php
            // Ambil data siswa dari database
            include '../auth/koneksi.php';
            $query = mysqli_query($mysqli, "SELECT student_id, nama FROM tb_siswa");
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<option value='" . $row['student_id'] . "'>" . $row['nama'] . "</option>";
            }
            ?>
        </select>
        <br>

        <label>Bahasa Indonesia:</label>
        <input type="number" step="0.01" name="bahasa_indonesia" required>
        <br>

        <label>Matematika:</label>
        <input type="number" step="0.01" name="matematika" required>
        <br>

        <label>IPA:</label>
        <input type="number" step="0.01" name="ipa" required>
        <br>

        <button type="submit">Tambah</button>
    </form>
</body>
</html>