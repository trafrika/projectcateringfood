<?php
session_start();
include('../config.php');

// Cek jika admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header("location:index.php");
    exit();
}

// Ambil data admin dan saran customer
$admin_id = $_SESSION['admin_id'];
$query_admin = "SELECT * FROM ADM WHERE ID_ADMIN = '$admin_id'";
$result_admin = mysqli_query($conn, $query_admin);
$admin = mysqli_fetch_assoc($result_admin);

// Ambil saran customer
$query_saran = "SELECT * FROM customer_suggestions ORDER BY created_at DESC LIMIT 5"; // Ambil 5 saran terbaru
$result_saran = mysqli_query($conn, $query_saran);

// Menghitung jumlah pengguna, jumlah pesanan, dan jumlah saran
$query_users = "SELECT COUNT(*) AS total_users FROM customer";
$result_users = mysqli_query($conn, $query_users);
$total_users = mysqli_fetch_assoc($result_users)['total_users'];

$query_orders = "SELECT COUNT(*) AS total_orders FROM PESANAN";
$result_orders = mysqli_query($conn, $query_orders);
$total_orders = mysqli_fetch_assoc($result_orders)['total_orders'];

$query_suggestions = "SELECT COUNT(*) AS total_suggestions FROM customer_suggestions";
$result_suggestions = mysqli_query($conn, $query_suggestions);
$total_suggestions = mysqli_fetch_assoc($result_suggestions)['total_suggestions'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Catering Makanan</title>
    <!-- Link ke CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        /* Background Gradien dengan warna biru dan hijau */
        body {
            background: linear-gradient(135deg, #0d6efd, #28a745); /* Biru ke Hijau */
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background-color: #343a40; /* Hitam */
            padding: 30px 20px;
            height: 100vh;
            border-radius: 10px;
        }

        .sidebar a {
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #fd7e14; /* Oranye pada hover */
        }

        .sidebar .active {
            background-color: #fd7e14; /* Oranye saat aktif */
        }

        .content {
            padding: 30px;
            background-color: #ffffff; /* Putih */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.5rem;
        }

        /* Gambar Profil */
        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
        }

        .card-header {
            background-color: #f8f9fa;
            color: #333;
            border-radius: 10px 10px 0 0;
        }

        .table-container {
            margin-top: 30px;
        }

        .table thead {
            background-color: #0d6efd; /* Biru */
            color: white;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .stats-card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .stats-card .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats-card i {
            font-size: 2rem;
        }

        .stats-card .card-text {
            font-size: 1.5rem;
        }

        .stats-card.bg-primary {
            background-color: #0d6efd; /* Biru */
        }

        .stats-card.bg-success {
            background-color: #28a745; /* Hijau */
        }

        .stats-card.bg-warning {
            background-color: #fd7e14; /* Oranye */
        }

        /* Card untuk Saran Customer */
        .card-saran {
            background-color: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .list-group-item {
            background-color: #ffffff !important;
            border: 1px solid #ccc;
        }

        /* Mengubah warna teks pada bagian "Selamat Datang" dan Nama Admin */
        .text-black {
            color: #333; /* Warna gelap untuk teks */
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .stats-box {
            flex: 1;
            margin-right: 15px;
            margin-left: 15px;
        }

        .stats-box:last-child {
            margin-right: 0;
        }

        .stats-box .card {
            border-radius: 15px;
        }

        .stats-box .card-body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .stats-box .card-body i {
            font-size: 4rem;
            margin-bottom: 15px;
        }

        .stats-box .card-body .card-text {
            font-size: 1.8rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Menu -->
        <div class="col-md-3 sidebar">
            <h1 class="text-center text-white mb-4">Dashboard</h1>
            <ul class="list-unstyled">
                <li><a href="dashboard.php" class="d-block py-2">Dashboard</a></li>
                <li><a href="customer.php" class="d-block py-2">Data Customer</a></li>
                <li><a href="tinjau.php" class="d-block py-2">Peninjauan Pemesanan</a></li>
                <li><a href="riwayat.php" class="d-block py-2 active">Riwayat Pemesanan</a></li>
                <li><a href="admin_menu.php" class="d-block py-2">Daftar Menu</a></li>
                <li><a href="daftar_koki.php" class="d-block py-2">Daftar Koki</a></li>
                <li><a href="logout.php" class="d-block py-2">Logout</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 content">
            <!-- Admin Profile and Greeting -->
            <div class="row mb-4">
                <div class="col-md-3 text-center">
                    <img src="../uploads/<?= $admin['FOTO_ADMIN'] ?>" class="profile-img" alt="Foto Profil">
                </div>
                <div class="col-md-9">
                    <h2 class="text-black">Selamat Datang, <?= $admin['NAMA_ADMIN'] ?>!</h2>
                    <p class="text-black">Anda berhasil login sebagai admin. Berikut adalah beberapa informasi terkait saran dari customer.</p>
                </div>
            </div>

            <!-- Saran Customer -->
            <div class="card-saran mb-4">
                <div class="card-header">
                    <h5>Saran Customer Terbaru</h5>
                </div>
                <div class="card-body">
                    <?php if (mysqli_num_rows($result_saran) > 0): ?>
                        <ul class="list-group">
                            <?php while ($saran = mysqli_fetch_assoc($result_saran)): ?>
                                <li class="list-group-item">
                                    <strong><?= $saran['customer_name'] ?>:</strong> <?= $saran['saran'] ?>
                                    <br><small class="text-muted"><?= $saran['created_at'] ?></small>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Belum ada saran dari customer.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stats / Info -->
            <div class="stats-container">
                <div class="stats-box">
                    <div class="card stats-card text-white bg-primary">
                        <div class="card-body">
                            <i class="fas fa-box"></i>
                            <div>
                                <h5 class="card-title">Jumlah Order</h5>
                                <p class="card-text"><?= $total_orders ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stats-box">
                    <div class="card stats-card text-white bg-success">
                        <div class="card-body">
                            <i class="fas fa-users"></i>
                            <div>
                                <h5 class="card-title">Jumlah Pengguna</h5>
                                <p class="card-text"><?= $total_users ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stats-box">
                    <div class="card stats-card text-white bg-warning">
                        <div class="card-body">
                            <i class="fas fa-comment-dots"></i>
                            <div>
                                <h5 class="card-title">Jumlah Saran</h5>
                                <p class="card-text"><?= $total_suggestions ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</body>
</html>
