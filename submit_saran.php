<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = $_POST['customer_name'];
    $saran = $_POST['saran'];

    // Query untuk memasukkan saran ke database
    $query = "INSERT INTO customer_suggestions (customer_name, saran) VALUES ('$customer_name', '$saran')";

    if ($conn->query($query)) {
        // Jika berhasil, tampilkan pesan sukses
        header('Location: faq.php?success=1');
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        $error = "Terjadi kesalahan. Saran gagal dikirim.";
    }
}
?>
