<?php
require_once 'auth.php';
wajibLogin('admin');

include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    mysqli_query(
        $koneksi,
        "DELETE FROM tb_mbg WHERE id_mbg = $id"
    );
}

header("Location: tampilMBG.php");
exit;