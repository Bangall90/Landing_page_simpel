<?php

// ini adalah data base kamu
$hostname = "localhost"; 
$username = "root";
$password = "";
$database_name = "buku_tamu";

// Ini adalah koneksi data base kamu
$db = mysqli_connect($hostname, $username, $password, $database_name);

// Ini untuk mengecek apakah koneksi pada data base kamu berhasil atau tidak
if($db->connect_error) {
    echo "koneksi data base rusak";
    die("error!"); 
}


?>
