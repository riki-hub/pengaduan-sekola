<?php 
session_start(); 
include "koneksi.php"; 
 
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') { 
    header("Location: login.php"); 
    exit(); 
} 
 
$id = $_GET['id']; 
$query = mysqli_query($koneksi, "SELECT aspirasi.*, users.nama  
                                 FROM aspirasi  
                                 JOIN users ON aspirasi.id_user = users.id  
                                 WHERE aspirasi.id='$id'"); 
$data = mysqli_fetch_assoc($query); 
?> 
<!DOCTYPE html> 
<html> 
<head> 
    <title>Detail Aspirasi</title> 
    <link rel="stylesheet" href="style.css"> 
</head> 
<body> 
<h2>Detail Aspirasi</h2> 
 
<p><strong>Nama Kelas:</strong> <?= $data['nama']; ?></p> 
<p><strong>Kategori:</strong> <?= $data['kategori']; ?></p> 
<p><strong>Barang:</strong> <?= $data['barang']; ?></p> 
<p><strong>Keterangan:</strong> <?= $data['judul']; ?></p> 
<p><strong>Isi:</strong> <?= $data['isi']; ?></p> 
<p><strong>Status:</strong> <?= $data['status']; ?></p> 
 
<form action="proses_status.php" method="post"> 
    <input type="hidden" name="id" value="<?= $data['id']; ?>"> 
 
    <label>Status Baru</label> 
    <select name="status" required> 
        <option value="Diajukan" <?= $data['status'] == 'Diajukan' ? 'selected' : '' 
?>>Diajukan</option> 
        <option value="Diproses" <?= $data['status'] == 'Diproses' ? 'selected' : '' 
?>>Diproses</option> 
        <option value="Selesai" <?= $data['status'] == 'Selesai' ? 'selected' : '' 
?>>Selesai</option> 
    </select> 
 
    <label>Feedback</label> 
    <select name="feedback" required> 
        <option value="">-- Pilih Feedback --</option> 
        <option value="Baik, akan kami proses." <?= $data['feedback'] == 'Baik, akan kami 
proses.' ? 'selected' : '' ?>>Baik, akan kami proses.</option> 
        <option value="Sudah kami teruskan ke bagian terkait." <?= $data['feedback'] == 
'Sudah kami teruskan ke bagian terkait.' ? 'selected' : '' ?>>Sudah kami teruskan ke 
bagian terkait.</option> 
        <option value="Terima kasih atas laporannya." <?= $data['feedback'] == 'Terima 
kasih atas laporannya.' ? 'selected' : '' ?>>Terima kasih atas laporannya.</option> 
        <option value="Sedang dalam penanganan." <?= $data['feedback'] == 'Sedang 
dalam penanganan.' ? 'selected' : '' ?>>Sedang dalam penanganan.</option> 
        <option value="Masalah sudah diselesaikan." <?= $data['feedback'] == 'Masalah 
sudah diselesaikan.' ? 'selected' : '' ?>>Masalah sudah diselesaikan.</option> 
        <option value="Lainnya">Lainnya</option> 
    </select> 
 
    <button type="submit">Simpan Perubahan</button> 
</form> 
<br> 
<a href="dashboard_admin.php">Kembali ke Dashboard</a> 
</body> 
</html>