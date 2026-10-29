<?php
// require_once 'auth.php'; 
// wajibLogin('admin');
include 'koneksi.php';

$siswa = mysqli_query($koneksi, "SELECT * FROM tb_siswa");

if (isset($_POST['submit'])) {
    $id_siswa = $_POST['id_siswa'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status_terima'];

    mysqli_query($koneksi, "INSERT INTO tb_mbg
        VALUES (NULL, '$id_siswa', '$tanggal', '$status')");

    header("Location: tampilMBG.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Tambah MBG</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
body{background:#f4f7fb;padding:20px}
h2{text-align:center;color:#2c3e50;margin-bottom:20px}
form{background:white;max-width:450px;margin:0 auto;padding:25px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,.1)}
label{font-weight:600;color:#34495e;font-size:14px;display:block;margin-bottom:5px}
select,input{width:100%;padding:11px;margin-bottom:18px;border:1px solid #ddd;border-radius:8px;font-size:14px}
select:focus,input:focus{outline:none;border-color:#3498db;box-shadow:0 0 0 2px rgba(52,152,219,.2)}
button{width:100%;padding:12px;background:#27ae60;color:white;border:none;border-radius:8px;font-weight:bold;cursor:pointer;font-size:15px}
button:hover{background:#219653}
a{display:block;text-align:center;margin-top:15px;text-decoration:none;color:#2c3e50;font-weight:600}
</style>
</head>
<body>
    <h2>Pencatatan Distribusi MBG</h2>
    <form method="POST">
        <label>Pilih Siswa:</label>
        <select name="id_siswa" required>
            <option value="">-- Pilih Siswa --</option>
            <?php while($s = mysqli_fetch_assoc($siswa)) { ?>
                <option value="<?= $s['id_siswa']; ?>"><?= $s['nama']; ?> (<?= $s['kelas']; ?>)</option>
            <?php } ?>
        </select>
        
        <label>Tanggal:</label>
        <input type="date" name="tanggal" required>
        
        <label>Status Penerimaan:</label>
        <select name="status_terima">
            <option value="diterima">Diterima</option>
            <option value="tidak_diterima">Tidak Diterima</option>
        </select>
        
        <button type="submit" name="submit">Simpan</button>
        <a href="tampilMBG.php">Kembali ke Data MBG</a>
    </form>
</body>
</html>