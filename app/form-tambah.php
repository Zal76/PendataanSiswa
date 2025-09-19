<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Data Warga</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h3>Form Tambah Data Warga</h3>
    <form action="tambah-data.php" method="POST" id="wargaForm" novalidate>
        <div class="form-group col-md-6">
            <label for="inputNama">Nama Lengkap</label>
            <input name="nama_lengkap" type="text" class="form-control" id="inputNama" placeholder="Nama Lengkap" required>
            <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
        </div>
        
        <div class="form-group col-md-6">
            <label for="inputTanggalLahir">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" id="inputTanggalLahir" required>
            <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
        </div>
    
        <div class="form-group col-md-6">
            <label for="inputAlamat">Alamat</label>
            <textarea name="alamat" class="form-control" id="inputAlamat" placeholder="Alamat" required></textarea>
            <div class="invalid-feedback">Alamat wajib diisi.</div>
        </div>
    
        <div class="form-group col-md-6">
            <label for="inputTelepon">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" class="form-control" id="inputTelepon" placeholder="Nomor Telepon" pattern="\d{10,13}" required>
            <div class="invalid-feedback">Nomor telepon wajib diisi dan harus berupa angka (10-13 digit).</div>
        </div>
    
        <div class="form-group col-md-6">
            <label for="inputPekerjaan">Pekerjaan</label>
            <select name="id_pekerjaan" class="form-control" id="inputPekerjaan" required>
                <option value="">Pilih Pekerjaan</option>
                <?php
                include '../auth/koneksi.php';
                $query = mysqli_query($mysqli, "SELECT * FROM pekerjaan");
                while ($row = mysqli_fetch_array($query)) {
                    echo "<option value='" . htmlspecialchars($row['id_pekerjaan'], ENT_QUOTES, 'UTF-8') . "'>" 
                         . htmlspecialchars($row['nama_pekerjaan'], ENT_QUOTES, 'UTF-8') . "</option>";
                }
                ?>
            </select>
            <div class="invalid-feedback">Silakan pilih pekerjaan.</div>
        </div>
      
        <div class="form-row">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var form = document.getElementById('wargaForm');
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    })();
</script>
</body>
</html>
