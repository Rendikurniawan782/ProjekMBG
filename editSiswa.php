<?php
require_once 'auth.php';
wajibLogin('admin');

include "koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($koneksi,
    "SELECT * FROM tb_siswa WHERE id_siswa='$id'"
);

$siswa = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];

    mysqli_query($koneksi, "UPDATE tb_siswa SET
        nis='$nis',
        nama='$nama',
        kelas='$kelas'
        WHERE id_siswa='$id'
    ");

    header("Location: tampilSiswa.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-xl mx-auto p-5">

    <div class="bg-white p-6 rounded-lg shadow">

        <h1 class="text-2xl font-bold mb-5">Edit Data Siswa</h1>

        <form method="POST">

            <label>NIS</label>
            <input type="text" name="nis"
                   value="<?= htmlspecialchars($siswa['nis']); ?>"
                   required
                   class="w-full border p-2 rounded mb-4">

            <label>Nama</label>
            <input type="text" name="nama"
                   value="<?= htmlspecialchars($siswa['nama']); ?>"
                   required
                   class="w-full border p-2 rounded mb-4">

            <label>Kelas</label>
            <input type="text" name="kelas"
                   value="<?= htmlspecialchars($siswa['kelas']); ?>"
                   required
                   class="w-full border p-2 rounded mb-4">

            <button type="submit" name="update"
                    class="bg-green-600 text-white px-4 py-2 rounded">
                Update
            </button>

            <a href="tampilSiswa.php"
               class="bg-gray-500 text-white px-4 py-2 rounded">
                Kembali
            </a>

        </form>

    </div>

</div>

</body>
</html>