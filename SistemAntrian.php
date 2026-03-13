<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_rumah_sakit";

$conn = mysqli_connect($host, $user, $pass, $db);

/* Error Handling: Cek koneksi */
if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>