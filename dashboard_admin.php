<?php 
session_start(); 
include "koneksi.php"; 
 
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') { 
    header("Location: login.php"); 
    exit(); 
} 
?> 
<!DOCTYPE html> 
<html> 
<head> 
    <title>Dashboard Admin</title> 
    <link rel="stylesheet" href="style.css"> 
    <style> 
        .foto-preview { 
            width: 80px; 
            height: auto; 
            border-radius: 5px; 
        } 
    </style> 
</head> 
<body> 
<h2>Dashboard Admin</h2> 
<p>Selamat datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p> 
<a href="logout.php">Logout</a> 
<table> 
<tr> 
    <th>No</th> 
    <th>Tanggal</th> 
    <th>Nama Kelas</th> 
    <th>Kategori</th> 
    <th>Judul</th> 
    <th>Status</th> 
    <th>Foto</th> 
    <th>Aksi</th> 
</tr> 
<?php 
$no = 1; 
$query = "SELECT aspirasi.*, users.nama  
          FROM aspirasi  
          JOIN users ON aspirasi.id_user = users.id  
          ORDER BY aspirasi.tanggal DESC"; 
$result = mysqli_query($koneksi, $query); 
if (!$result) { 
    die("Query error: " . mysqli_error($koneksi)); 
} 
 
while ($d = mysqli_fetch_assoc($result)) { 
    if ($d['foto']) { 
        $foto = "<img src='uploads/{$d['foto']}' class='foto-preview'>"; 
    } else { 
        $foto = "-"; 
    } 
 
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
        <td>{$d['nama']}</td> 
        <td>{$d['kategori']}</td> 
        <td>{$d['judul']}</td> 
        <td> 
        <span style='padding:4px 10px; border-radius:12px; color:white; font
weight:bold; background-color:$warna;'> 
            $status 
        </span> 
    </td> 
        <td>$foto</td> 
        <td><a href='detail_aspirasi.php?id={$d['id']}'>Detail</a></td> 
    </tr>"; 
    $no++; 
} 
?> 
</table> 
</body> 
</html>