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

if ($id_customer == 0) {
    header("Location: customer.php");
    exit();
}

// Ambil data customer berdasarkan ID
$query = "SELECT * FROM CUSTOMER WHERE ID_CUSTOMER = '$id_customer'";
$result = $conn->query($query);
$customer = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_customer = $_POST['nama_customer'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];

    // Update data customer
    $query_update = "UPDATE CUSTOMER SET NAMA_CUSTOMER='$nama_customer', EMAIL='$email', ALAMAT='$alamat' WHERE ID_CUSTOMER='$id_customer'";
    
    if ($conn->query($query_update)) {
        header("Location: customer.php?message=Data berhasil diperbarui");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer - Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Customer</h2>

    <form method="POST" action="">
        <div class="form-group">
            <label for="nama_customer">Nama:</label>
            <input type="text" name="nama_customer" id="nama_customer" class="form-control" value="<?= htmlspecialchars($customer['NAMA_CUSTOMER']); ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($customer['EMAIL']); ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea name="alamat" id="alamat" class="form-control" required><?= htmlspecialchars($customer['ALAMAT']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="customer.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

