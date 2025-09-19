<?php
include '../auth/koneksi.php';

$id_warga = intval($_GET['id']);
$query = mysqli_query($mysqli, "SELECT * FROM warga WHERE id_warga = '$id_warga'");
$data = mysqli_fetch_array($query);

if (!$data) {
    die("Data tidak ditemukan");
}

$queryPekerjaan = mysqli_query($mysqli, "SELECT * FROM pekerjaan");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Warga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h3>Edit Data Warga</h3>
    <form action="edit-data.php" method="POST" id="editForm">
        <input type="hidden" name="id_warga" value="<?php echo htmlspecialchars($data['id_warga'], ENT_QUOTES, 'UTF-8'); ?>">
        
        <div class="form-group col-md-6">
            <label for="inputNama">Nama Lengkap</label>
            <input name="nama_lengkap" type="text" class="form-control" id="inputNama" 
                   value="<?php echo htmlspecialchars($data['nama_lengkap'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="inputTanggalLahir">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" id="inputTanggalLahir" 
                   value="<?php echo htmlspecialchars($data['tanggal_lahir'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
    
        <div class="form-group col-md-6">
            <label for="inputAlamat">Alamat</label>
            <textarea name="alamat" class="form-control" id="inputAlamat" required><?php echo htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
    
        <div class="form-group col-md-6">
            <label for="inputTelepon">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control" id="inputTelepon" 
                   value="<?php echo htmlspecialchars($data['nomor_telepon'], ENT_QUOTES, 'UTF-8'); ?>" pattern="\d{10,13}" required>
        </div>
    
        <div class="form-group col-md-6">
            <label for="inputPekerjaan">Pekerjaan</label>
            <select name="id_pekerjaan" class="form-control" id="inputPekerjaan" required>
                <option value="">Pilih Pekerjaan</option>
                <?php
                while ($row = mysqli_fetch_array($queryPekerjaan)) {
                    $selected = $row['id_pekerjaan'] == $data['id_pekerjaan'] ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($row['id_pekerjaan'], ENT_QUOTES, 'UTF-8') . "' $selected>" 
                         . htmlspecialchars($row['nama_pekerjaan'], ENT_QUOTES, 'UTF-8') . "</option>";
                }
                ?>
            </select>
        </div>
      
        <div class="form-row">
            <button type="submit" class="btn btn-primary">Edit</button>
            <a href="../home.php?page=data-warga" class="btn btn-secondary ml-2">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
