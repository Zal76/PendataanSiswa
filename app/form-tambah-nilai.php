<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Tambah Nilai Siswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h3>Form Tambah Nilai Siswa</h3>
  <form action="tambah-nilai.php" method="POST" id="nilaiForm" novalidate>

    <div class="form-group col-md-6">
      <label for="inputSiswa">Siswa</label>
      <select name="student_id" id="inputSiswa" class="form-control" required>
        <option value="">Pilih Siswa</option>
        <?php
          include '../auth/koneksi.php';
          $query = mysqli_query($mysqli, "SELECT student_id, nama FROM tb_siswa");
          while ($row = mysqli_fetch_assoc($query)) {
            echo "<option value='" . $row['student_id'] . "'>" . $row['nama'] . "</option>";
          }
        ?>
      </select>
      <div class="invalid-feedback">Siswa wajib dipilih.</div>
    </div>

    <div class="form-group col-md-6">
      <label for="inputBi">Bahasa Indonesia</label>
      <input type="number" step="0.01" name="bahasa_indonesia" class="form-control" id="inputBi" placeholder="Nilai Bahasa Indonesia" required>
      <div class="invalid-feedback">Nilai Bahasa Indonesia wajib diisi (format angka desimal).</div>
    </div>

    <div class="form-group col-md-6">
      <label for="inputMatematika">Matematika</label>
      <input type="number" step="0.01" name="matematika" class="form-control" id="inputMatematika" placeholder="Nilai Matematika" required>
      <div class="invalid-feedback">Nilai Matematika wajib diisi (format angka desimal).</div>
    </div>

    <div class="form-group col-md-6">
      <label for="inputIpa">IPA</label>
      <input type="number" step="0.01" name="ipa" class="form-control" id="inputIpa" placeholder="Nilai IPA" required>
      <div class="invalid-feedback">Nilai IPA wajib diisi (format angka desimal).</div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="home.php" class="btn btn-secondary">Kembali</a>

  </form>
</div>

<script>
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      var form = document.getElementById('nilaiForm');
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