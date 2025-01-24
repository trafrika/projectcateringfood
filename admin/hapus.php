<?php
include('../config.php'); // Pastikan jalur ini benar

// Cek jika admin sudah login
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("location:index.php");
    exit();
}

// Cek jika ada ID customer di URL
$id_customer = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id_customer != 0) {
    // Menonaktifkan sementara foreign key checks
    $conn->query("SET foreign_key_checks = 0");

    // Hapus data customer tanpa menghapus pesanan
    $query_delete_customer = "DELETE FROM customer WHERE ID_CUSTOMER='$id_customer'";
    if ($conn->query($query_delete_customer)) {
        // Aktifkan kembali foreign key checks
        $conn->query("SET foreign_key_checks = 1");

        header("Location: customer.php?message=Data berhasil dihapus");
        exit();
    } else {
        echo "Error deleting customer: " . $conn->error;
        // Aktifkan kembali foreign key checks
        $conn->query("SET foreign_key_checks = 1");
    }
} else {
    header("Location: customer.php");
}
?>