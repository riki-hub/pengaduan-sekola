<?php 
session_start(); 
include "koneksi.php"; 
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'siswa') { 
    header("Location: login.php"); 
    exit(); 
} 
$id_user = $_SESSION['user']['id']; 
?> 
<!DOCTYPE html> 
<html> 
<head> 
    <title>Dashboard Siswa</title> 
    <link rel="stylesheet" href="style.css"> 
</head> 
<body> 
<h2>Dashboard Pengaduan Sarpras</h2> 
<p>Selamat datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p> 
<a href="index.php">+ Buat Pengaduan</a> |  
<a href="logout.php">Logout</a> 
<table border="1" cellpadding="8" cellspacing="0"> 
<tr> 
    <th>No</th> 
    <th>Tanggal</th> 
    <th>Kategori</th> 
    <th>Barang</th> 
    <th>Keterangan</th> 
    <th>Status</th> 
    <th>Feedback</th> 
    <th>Foto</th> 
</tr> 
<?php 
$no = 1; 
$query = mysqli_query($koneksi, "SELECT * FROM aspirasi WHERE id_user = 
'$id_user' ORDER BY tanggal DESC"); 
if (!$query) { 
    die("Query error: " . mysqli_error($koneksi)); 
} 
while ($d = mysqli_fetch_assoc($query)) { 
    $foto = $d['foto']  
        ? "<img src='uploads/{$d['foto']}' width='80' height='80' style='object-fit:cover; 
border-radius:8px;'>" 
        : "-"; 
        $status = !empty($d['status']) ? $d['status'] : 'Menunggu'; 
if ($status == 'Menunggu') { 
    $warna = 'gold'; 
} elseif ($status == 'Diajukan') { 
    $warna = 'orange'; 
} elseif ($status == 'Diproses') { 
    $warna = 'green'; 
} elseif ($status == 'Selesai') { 
    $warna = 'red'; 
} else { 
    $warna = 'gray'; 
} 
echo "<tr> 
        <td>{$no}</td> 
        <td>{$d['tanggal']}</td> 
        <td>{$d['kategori']}</td> 
        <td>" . (!empty($d['barang']) ? $d['barang'] : '-') . "</td> 
        <td>{$d['judul']}</td> 
        <td> 
            <span style='padding:4px 10px; border-radius:12px; color:white; font-weight:bold; 
background-color:$warna;'> 
                $status 
            </span> 
        </td> 
        <td>" . (!empty($d['feedback']) ? $d['feedback'] : '-') . "</td> 
        <td>$foto</td> 
    </tr>"; 
    $no++;  
} 
?> 
</table> 
</body> 
</html> 