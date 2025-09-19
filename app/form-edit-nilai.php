<?php
include '../auth/koneksi.php';
session_start();

// Ambil id_nilai dari URL
if (isset($_GET['id'])) {
    $id_nilai = $_GET['id'];

    // Query untuk mengambil data nilai berdasarkan id_nilai
    $stmt = $mysqli->prepare("SELECT * FROM tb_nilai WHERE id_nilai = ?");
    $stmt->bind_param("i", $id_nilai);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        $_SESSION['error'] = "Data tidak ditemukan!";
        header('Location: home.php?page=data-nilai');
        exit;
    }
} else {
    $_SESSION['error'] = "ID tidak valid!";
    header('Location: home.php?page=data-nilai');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Edit Nilai Siswa - <?php echo $data['nama']; ?></h3>
    <form action="edit-nilai.php" method="POST">
        <input type="hidden" name="id_nilai" value="<?php echo $data['id_nilai']; ?>">

        <div class="form-group">
            <label for="inputBi">Bahasa Indonesia</label>
            <input type="number" step="0.01" name="bahasa_indonesia" class="form-control" id="inputBi" value="<?php echo $data['bahasa_indonesia']; ?>" required>
        </div>

        <div class="form-group">
            <label for="inputMatematika">Matematika</label>
            <input type="number" step="0.01" name="matematika" class="form-control" id="inputMatematika" value="<?php echo $data['matematika']; ?>" required>
        </div>

        <div class="form-group">
            <label for="inputIpa">IPA</label>
            <input type="number" step="0.01" name="ipa" class="form-control" id="inputIpa" value="<?php echo $data['ipa']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="home.php?page=data-nilai" class="btn btn-secondary ml-2">Batal</a>
    </form>
</div>
</body>
</html>
