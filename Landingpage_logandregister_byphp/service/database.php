<?php

// setup sesuai database kamu ini hanya contoh:
$hostname = "localhost"; 
$username = "root";
$password = "";
$database_name = "buku_tamu";

// Ini buat koneksi
$db = mysqli_connect($hostname, $username, $password, $database_name);

// Ini cek apakah koneksi berhasil atau tidak
if($db->connect_error) {
    echo "koneksi data base rusak";
    die("error!"); 
}

?>