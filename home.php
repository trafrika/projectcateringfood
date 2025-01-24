<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Jika belum login, arahkan ke halaman login
    exit;
}

// Ambil nama pengguna dari sesi
$user_name = $_SESSION['user_name'];
?>

<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Pemesanan Catering</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigasi -->
<?php include('navbar.php'); ?>

<!-- Hero Section -->
<div class="hero-section">
    <img src="images/bg_home1.jpg" alt="Gambar Hero Home" class="hero-image">
    <div class="hero-text">
        <h1>Selamat Datang di Catering Food, <?php echo htmlspecialchars($user_name); ?>!</h1>
        <p>Pilihan terbaik untuk kebutuhan katering Anda</p>
    </div>
</div>


<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>
