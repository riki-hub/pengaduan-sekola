<?php 
session_start(); 
include "koneksi.php"; 
?> 
<!DOCTYPE html> 
<html> 
<head> 
    <title>Login</title> 
    <link rel="stylesheet" href="style.css"> 
</head> 
<body> 
    <center> 
<h2>Login Pengguna</h2> 
 
<form method="post"> 
    <label>Username</label> 
    <input type="text" name="username" required> 
 
    <label>Password</label> 
    <input type="password" name="password" required> 
 
    <button type="submit" name="login">Login</button> 
</form> 
 
<?php 
if (isset($_POST['login'])) { 
    $username = mysqli_real_escape_string($koneksi, $_POST['username']); 
    $password = md5($_POST['password']); 
 
    $sql = "SELECT * FROM users WHERE username='$username' AND 
password='$password'"; 
    $result = mysqli_query($koneksi, $sql); 
 
    if (!$result) { 
        die("SQL Error: " . mysqli_error($koneksi)); 
    } 
 
    if (mysqli_num_rows($result) > 0) { 
        $data = mysqli_fetch_assoc($result); 
        $_SESSION['user'] = $data; 
 
        if ($data['role'] == 'admin') { 
            header("Location: dashboard_admin.php"); 
        } else { 
            header("Location: dashboard_siswa.php"); 
        } 
        exit(); 
    } else { 
        echo "<p style='color:red;'>Username atau password salah!</p>"; 
    } 
} 
?> 
</body> 
</html>