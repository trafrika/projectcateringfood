<?php
session_start();

// Cek apakah form login sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menangkap data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Koneksi ke database
    include('config.php');

    // Query untuk memeriksa apakah pengguna dengan email ini ada
    $sql = "SELECT * FROM CUSTOMER WHERE EMAIL = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Jika email ditemukan, verifikasi password
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password dengan password_hash
        if (password_verify($password, $user['PASS'])) {
            // Jika password cocok
            $_SESSION['user_id'] = $user['ID_CUSTOMER'];
            $_SESSION['user_name'] = $user['NAMA_CUSTOMER'];

            // Redirection ke halaman home.php setelah login sukses
            header('Location: home.php');
            exit;  // Pastikan script berhenti setelah redirect
        } else {
            // Jika password salah
            $error_message = "Password salah!";
        }
    } else {
        // Jika email tidak ditemukan di database
        $error_message = "Akun dengan email ini tidak ditemukan. Silakan daftar terlebih dahulu.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>Login</h2>

        <!-- Menampilkan pesan kesalahan jika ada -->
        <?php if (isset($error_message)): ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>
