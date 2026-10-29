<?php
require_once 'auth.php';
wajibLogin();

// INI YANG BIKIN LANGSUNG KE DATA SISWA - JANGAN DIHAPUS
if ($_SESSION['role'] === 'siswa') {
    header('Location: tampilSiswa.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendataan MBG</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7fb; padding: 20px; text-align: center; }
        nav a { display: inline-block; margin: 8px; padding: 12px 18px; background: #2c3e50; color: white; text-decoration: none; border-radius: 8px; }
        nav a:hover { background: #3498db; }
    </style>
</head>
<body>
    <h1>Aplikasi Pendataan MBG</h1>
    <p>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?></p>
    <p>Role: <?= htmlspecialchars($_SESSION['role']) ?></p>
    <nav>
        <a href="tampilSiswa.php">Kelola Data Siswa</a>
        <a href="tampilMBG.php">Kelola Data MBG</a>
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>