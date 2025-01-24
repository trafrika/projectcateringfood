<?php
include('../config.php');
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_menu'])) {
    $id_menu = $_GET['id_menu'];
    
    // Hapus menu dari database
    $query = "DELETE FROM PRODUK_MENU WHERE ID_MENU = '$id_menu'";

    if ($conn->query($query) === TRUE) {
        header("Location: admin_menu.php");
        exit();
    } else {
        $error = "Gagal menghapus menu: " . $conn->error;
    }
} else {
    header("Location: admin_menu.php");
    exit();
}
