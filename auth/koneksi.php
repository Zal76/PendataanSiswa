<?php

$host = 'localhost';
$dbname = 'pendataan_siswa';
$user = 'root';
$pass = '';

$mysqli = mysqli_connect($host,$user,$pass,$dbname);

if(!$mysqli){
    die("koneksi Gagal" . mysqli_connect_error());
}
//echo "Berhasil";
?>