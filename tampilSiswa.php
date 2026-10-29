<?php
include 'koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM tb_siswa");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
        body{background:#f4f7fb;padding:20px}
        h2{text-align:center;color:#2c3e50;margin-bottom:20px}
        .menu{text-align:center;margin-bottom:15px}
        .menu a{text-decoration:none;padding:10px 16px;color:white;border-radius:8px;margin:0 5px;font-weight:bold;display:inline-block}
        .menu a:first-child{background:#27ae60}
        .menu a:last-child{background:#2c3e50}
        .menu a:hover{opacity:.8}
        table{width:100%;background:white;border-collapse:collapse;border-radius:12px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,.1)}
        th{background:#3498db;color:white;padding:12px}
        td{padding:10px;text-align:center;border-bottom:1px solid #eee}
        tr:hover{background:#f1f9ff}
        .aksi a{text-decoration:none;padding:6px 10px;border-radius:6px;color:white;font-size:13px}
        .edit{background:#f39c12}
        .hapus{background:#e74c3c}
    </style>
</head>
<body>
    <h2>Data Siswa</h2>
        <div class="menu">
    <a href="tambahSiswa.php">[+] Tambah Siswa</a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="index.php">Kembali</a>
    <?php else: ?>
        <a href="logout.php">Logout</a>
    <?php endif; ?>
        </div>
    <table>
        <tr>
            <th>ID</th><th>NIS</th><th>Nama</th><th>Kelas</th><th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?= $row['id_siswa']; ?></td>
            <td><?= $row['nis']; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['kelas']; ?></td>
            <td class="aksi">
                <a class="edit" href="editSiswa.php?id=<?= $row['id_siswa']; ?>">Edit</a>
                <a class="hapus" href="hapusSiswa.php?id=<?= $row['id_siswa']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>