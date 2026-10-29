<?php
$host = "localhost";
$user = "root";
$pass = "";
// tes koneksi tanpa pilih database dulu
$koneksi = mysqli_connect("127.0.0.1", "root", "root", "CRUD_MBG", 3306);
    // cek database crud_mbg ada gak
$db_check = mysqli_select_db($koneksi, "CRUD_MBG");

// Memeriksa apakah database berhasil dipilih
if (!$db_check) {
    echo "Database crud_mbg GAK KETEMU. Daftar DB yang ada: <br>";
    $result = mysqli_query($koneksi, "SHOW DATABASES");
    while($row = mysqli_fetch_array($result)){
        echo "- ".$row[0]."<br>";
    }
} 

// Membuat variabel cadangan agar file tampilSiswa.php tidak eror
$dbCRUD_MBG = $koneksi;
?>
