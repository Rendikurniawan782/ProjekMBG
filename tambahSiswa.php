<?php
// require_once 'auth.php'; <- HAPUS / KOMEN
// wajibLogin('admin');      <- HAPUS / KOMEN
include 'koneksi.php';

$pesan = "";
if (isset($_POST['submit'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    $cek = mysqli_query($koneksi, "SELECT nis FROM tb_siswa WHERE nis='$nis'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "NIS $nis sudah terdaftar! Ganti NIS lain.";
    } else {
        mysqli_query($koneksi, "INSERT INTO tb_siswa VALUES(null, '$nis', '$nama', '$kelas')");
        header("Location: tampilSiswa.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
        body{background:#f4f7fb;padding:20px}
        h2{text-align:center;color:#2c3e50;margin-bottom:20px}
        form{background:white;max-width:400px;margin:auto;padding:20px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,.1)}
        input{width:100%;padding:10px;margin:6px 0 15px;border:1px solid #ccc;border-radius:8px}
        button{width:100%;padding:12px;background:#27ae60;color:white;border:none;border-radius:8px;font-weight:bold}
        button:hover{background:#219653}
        .alert{background:#e74c3c;color:white;padding:10px;border-radius:8px;margin-bottom:15px;text-align:center}
        a{text-align:center;display:block;margin-top:15px;color:#2c3e50;text-decoration:none}
    </style>
</head>
<body>
    <h2>Tambah Data Siswa</h2>
    <form method="POST">
        <?php if($pesan!=""){ echo "<div class='alert'>$pesan</div>"; } ?>
        NIS: <input type="text" name="nis" required>
        Nama: <input type="text" name="nama" required>
        Kelas: <input type="text" name="kelas" required>
        <button type="submit" name="submit">Simpan</button>
        <a href="tampilSiswa.php">Kembali</a>
    </form>
</body>
</html>