<?php
include 'koneksi.php';

// Cek ID
$id = $_GET['id'] ?? 0;
$id = mysqli_real_escape_string($koneksi, $id);

$data_q = mysqli_query($koneksi, "SELECT * FROM tb_mbg WHERE id_mbg = '$id'");
if(mysqli_num_rows($data_q) == 0){
    die("Data MBG tidak ditemukan! <a href='tampilMBG.php'>Kembali</a>");
}
$data = mysqli_fetch_assoc($data_q);

// Ambil semua siswa buat dropdown
$siswa_q = mysqli_query($koneksi, "SELECT * FROM tb_siswa ORDER BY kelas, nama ASC");

// Proses update
if(isset($_POST['update'])){
    $id_siswa = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status_terima']);

    mysqli_query($koneksi, "UPDATE tb_mbg SET 
        id_siswa = '$id_siswa',
        tanggal = '$tanggal',
        status_terima = '$status'
        WHERE id_mbg = '$id'");

    header("Location: tampilMBG.php?edit=sukses");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit MBG</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
body{background:#f4f7fb;padding:20px}
h2{text-align:center;color:#2c3e50;margin-bottom:20px}
form{background:white;max-width:450px;margin:0 auto;padding:25px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,.1)}
label{font-weight:600;color:#34495e;font-size:14px;display:block;margin-bottom:5px}
select,input{width:100%;padding:11px;margin-bottom:18px;border:1px solid #ddd;border-radius:8px;font-size:14px}
select:focus,input:focus{outline:none;border-color:#f39c12;box-shadow:0 0 0 2px rgba(243,156,18,.2)}
button{width:100%;padding:12px;background:#f39c12;color:white;border:none;border-radius:8px;font-weight:bold;cursor:pointer;font-size:15px}
button:hover{background:#e67e22}
a.kembali{display:block;text-align:center;margin-top:15px;text-decoration:none;color:#2c3e50;font-weight:600;background:#eee;padding:10px;border-radius:8px}
.info{background:#fff3cd;border-left:4px solid #f39c12;padding:10px;border-radius:8px;margin-bottom:15px;font-size:13px;color:#856404}
</style>
</head>
<body>
<h2>Edit Data MBG #<?= $data['id_mbg'] ?></h2>

<form method="POST">
    <div class="info">Sedang mengedit data ID <?= $data['id_mbg'] ?> - Tanggal lama: <?= date('d-m-Y', strtotime($data['tanggal'])) ?></div>

    <label>Pilih Siswa:</label>
    <select name="id_siswa" required>
        <?php while($s = mysqli_fetch_assoc($siswa_q)) { ?>
            <option value="<?= $s['id_siswa'] ?>" <?= $s['id_siswa']==$data['id_siswa']?'selected':'' ?>>
                <?= $s['nama'] ?> (<?= $s['kelas'] ?>)
            </option>
        <?php } ?>
    </select>

    <label>Tanggal:</label>
    <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required>

    <label>Status Penerimaan:</label>
    <select name="status_terima" required>
        <option value="diterima" <?= $data['status_terima']=='diterima'?'selected':'' ?>>Diterima</option>
        <option value="tidak_diterima" <?= $data['status_terima']=='tidak_diterima'?'selected':'' ?>>Tidak Diterima</option>
    </select>

    <button type="submit" name="update">Update Data</button>
    <a class="kembali" href="tampilMBG.php">Batal - Kembali</a>
</form>
</body>
</html>