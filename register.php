<?php
// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menangkap data form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password dan konfirmasi password
    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan Konfirmasi Password tidak cocok!');</script>";
    } else {
        // Koneksi ke database
        include('config.php');
        
        // Hash password sebelum disimpan ke database
        // Hash password sebelum disimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        // Query untuk memasukkan data pengguna baru ke dalam database
        $sql = "INSERT INTO CUSTOMER (NAMA_CUSTOMER, EMAIL, ALAMAT, PASS) VALUES ('$nama', '$email', '$alamat', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Pendaftaran berhasil! Silakan login.'); window.location = 'login.php';</script>";
        } else {
            echo "<script>alert('Pendaftaran gagal! Coba lagi.');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="register-body">
    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Konfirmasi Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Register</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>