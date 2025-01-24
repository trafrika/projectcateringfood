<?php
$host = 'localhost';
$user = 'root';  // Ganti dengan username MySQL Anda
$password = '';  // Ganti dengan password MySQL Anda
$dbname = 'PEMESANAN_CATERING2';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

