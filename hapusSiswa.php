<?php
require_once 'auth.php';
wajibLogin('admin');

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    mysqli_query(
        $koneksi,
        "DELETE FROM tb_siswa WHERE id_siswa = $id"
    );
}

header("Location: tampilSiswa.php");
exit;