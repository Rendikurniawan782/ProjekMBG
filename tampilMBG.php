<?php
include 'koneksi.php';

$kelas_result = mysqli_query($koneksi, "SELECT DISTINCT kelas FROM tb_siswa ORDER BY kelas ASC");
$daftar_kelas = [];
while($k = mysqli_fetch_assoc($kelas_result)){ $daftar_kelas[] = $k['kelas']; }

$filter_tanggal = $_GET['tanggal'] ?? '';
$filter_kelas = $_GET['kelas'] ?? '';

$where = [];
if ($filter_tanggal != '') $where[] = "tb_mbg.tanggal = '".mysqli_real_escape_string($koneksi, $filter_tanggal)."'";
if ($filter_kelas != '') $where[] = "tb_siswa.kelas = '".mysqli_real_escape_string($koneksi, $filter_kelas)."'";
$where_sql = $where ? "WHERE ".implode(" AND ", $where) : "";

$query = mysqli_query($koneksi, "SELECT tb_mbg.*, tb_siswa.nama, tb_siswa.kelas FROM tb_mbg JOIN tb_siswa ON tb_mbg.id_siswa=tb_siswa.id_siswa $where_sql ORDER BY tb_mbg.tanggal DESC");
$ringkasan_q = mysqli_query($koneksi, "SELECT SUM(CASE WHEN tb_mbg.status_terima='diterima' THEN 1 ELSE 0 END) as total_diterima, SUM(CASE WHEN tb_mbg.status_terima='tidak_diterima' THEN 1 ELSE 0 END) as total_tidak, COUNT(*) as total_semua FROM tb_mbg JOIN tb_siswa ON tb_mbg.id_siswa=tb_siswa.id_siswa $where_sql");
$ringkasan = mysqli_fetch_assoc($ringkasan_q);
?>
<!DOCTYPE html>
<html><head><title>Data MBG</title><meta name="viewport" content="width=device-width, initial-scale=1">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
body{background:#f4f7fb;padding:15px}.container{max-width:1100px;margin:0 auto}
h2{text-align:center;color:#2c3e50;margin-bottom:10px}
.menu{text-align:center;margin-bottom:10px}.menu a{padding:10px 16px;border-radius:8px;color:white;font-weight:bold;text-decoration:none;margin:3px;display:inline-block}
.btn-tambah{background:#27ae60}.btn-kembali{background:#2c3e50}
.filter-box{background:white;padding:12px;border-radius:12px;display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;box-shadow:0 2px 8px rgba(0,0,0,.08)}
.filter-box input,.filter-box select{padding:10px;border:1px solid #ddd;border-radius:8px;flex:1}
.btn-filter{background:#3498db;color:white;border:none;padding:10px 16px;border-radius:8px;font-weight:bold}
.btn-reset{background:#95a5a6;color:white;padding:10px 16px;border-radius:8px;border:none;font-weight:bold;cursor:pointer}
.ringkasan{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:12px}
.card{background:white;padding:12px;border-radius:12px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,.08)}.card h3{font-size:22px}
.info-tgl{background:#e8f5e9;border-left:4px solid #27ae60;padding:10px;border-radius:8px;margin-bottom:12px;font-weight:600;color:#2e7d32}
table{width:100%;background:white;border-collapse:collapse;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.08)}
th{background:#3498db;color:white;padding:10px;font-size:13px}td{padding:8px;text-align:center;border-bottom:1px solid #eee;font-size:13px}
.status-terima{background:#2ecc71;color:white;padding:4px 8px;border-radius:20px;font-size:11px}.status-tidak{background:#e74c3c;color:white;padding:4px 8px;border-radius:20px;font-size:11px}
.aksi a{padding:5px 8px;border-radius:6px;color:white;font-size:12px;margin:2px;display:inline-block;text-decoration:none}.edit{background:#f39c12}.hapus{background:#e74c3c}
</style>
</head><body>
<div class="container">
<h2>Data Penerimaan MBG</h2>
<div class="menu">
<a class="btn-tambah" href="tambahMBG.php">[+] Catat MBG</a>
<a class="btn-kembali" href="index.php">Kembali</a>
</div>

<form method="GET" action="" class="filter-box">
    <input type="date" name="tanggal" value="<?= $filter_tanggal ?>">
    <select name="kelas">
        <option value="">-- Semua Kelas --</option>
        <?php foreach($daftar_kelas as $kel){ ?>
            <option value="<?= $kel ?>" <?= $filter_kelas==$kel?'selected':'' ?>><?= $kel ?></option>
        <?php } ?>
    </select>
    <button type="submit" class="btn-filter">Filter</button>
    <button type="button" class="btn-reset" onclick="window.location.href=window.location.pathname">Reset</button>
</form>

<?php if($filter_tanggal){ ?>
<div class="info-tgl">Tanggal <?= date('d-m-Y', strtotime($filter_tanggal)) ?> : <b><?= $ringkasan['total_diterima'] ?> siswa</b> menerima MBG</div>
<?php } ?>

<div class="ringkasan">
    <div class="card"><h3 style="color:#27ae60"><?= $ringkasan['total_diterima'] ?? 0 ?></h3><p>Total Penerima</p></div>
    <div class="card"><h3 style="color:#e74c3c"><?= $ringkasan['total_tidak'] ?? 0 ?></h3><p>Total Tidak</p></div>
    <div class="card"><h3><?= $ringkasan['total_semua'] ?? 0 ?></h3><p>Total Data</p></div>
</div>

<table>
<tr><th>ID</th><th>Nama</th><th>Kelas</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
<?php while($row = mysqli_fetch_assoc($query)){ ?>
<tr>
<td><?= $row['id_mbg'] ?></td><td><?= $row['nama'] ?></td><td><?= $row['kelas'] ?></td>
<td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
<td><?= $row['status_terima']=='diterima' ? '<span class="status-terima">Diterima</span>' : '<span class="status-tidak">Tidak</span>' ?></td>
<td class="aksi">
<a class="edit" href="<?= basename($_SERVER['PHP_SELF'], '.php')=='tampilMBG'?'':'' ?>editMBG.php?id=<?= $row['id_mbg'] ?>">Edit</a>
<a class="hapus" href="hapusMBG.php?id=<?= $row['id_mbg'] ?>">Hapus</a>
</td>
</tr>
<?php } ?>
</table>
</div>

<script>
// Biar Edit/Hapus gak ketahan filter
document.querySelectorAll('.aksi a').forEach(a=>{
  a.addEventListener('click', function(e){
    if(this.classList.contains('hapus')){
      if(!confirm('Yakin hapus data ini?')) e.preventDefault();
    }
  });
});
</script>
</body></html>