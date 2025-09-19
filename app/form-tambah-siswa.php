<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Tambah Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h3>Form Tambah Siswa</h3>
  <form action="tambah-data.php" method="POST" id="siswaForm" novalidate>
    <div class="form-group col-md-6">
      <label for="inputNama">Nama Siswa</label>
      <input name="nama" type="text" class="form-control" id="inputNama" placeholder="Nama Siswa" required>
      <div class="invalid-feedback">Nama siswa wajib diisi.</div>
    </div>
    
    <div class="form-group col-md-6">
      <label for="inputNomorInduk">Nomor Induk</label>
      <input type="text" name="nomor_induk" class="form-control" id="inputNomorInduk" placeholder="Nomor Induk" required>
      <div class="invalid-feedback">Nomor induk wajib diisi.</div>
    </div>
    
    <div class="form-group col-md-6">
      <label for="jenisKelamin">Jenis Kelamin</label>
      <select name="jenis_kelamin" id="jenisKelamin" class="form-control" required>
        <option value="">Pilih Jenis Kelamin</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>
      <div class="invalid-feedback">Jenis kelamin wajib dipilih.</div>
    </div>
    
    <div class="form-group col-md-6">
      <label for="agama">Agama</label>
      <select name="agama" id="jenisKelamin" class="form-control" required>
        <option value="">Pilih Agama</option>
        <option value="islam">islam</option>
        <option value="kristen">kristen</option>
        <option value="buddha">buddha</option>
        <option value="hindu">hindu</option>
        <option value="konghuchu">konghuchu</option>
      </select>
      <div class="invalid-feedback">Jenis kelamin wajib dipilih.</div>
    </div>
    
    <div class="form-group col-md-6">
      <label for="alamat">Alamat</label>
      <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
      <div class="invalid-feedback">Alamat wajib diisi.</div>
    </div>
    
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="home.php" class="btn btn-secondary">Kembali</a>

  </form>
</div>

<script>
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      var form = document.getElementById('siswaForm');
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
