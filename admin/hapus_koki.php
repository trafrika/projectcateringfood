<?php
include('../config.php');
session_start();

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Ambil ID Koki dari URL
$id_koki = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id_koki == 0) {
    header("Location: daftar_koki.php");
    exit();
}

// Hapus koki dari database
$query = "DELETE FROM KOKI WHERE ID_KOKI = '$id_koki'";

if ($conn->query($query)) {
    header("Location: daftar_koki.php");
    exit();
} else {
    echo "Gagal menghapus koki: " . $conn->error;
}
?>
