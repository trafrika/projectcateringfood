<?php
session_start();  // Pastikan session dimulai
include('../config.php'); // Pastikan koneksi database
?>
<?php
// Pastikan session sudah dimulai
session_start();
include('../config.php'); // Koneksi ke database

// Cek jika admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");  // Redirect ke login jika belum login
    exit();
}

// Query untuk mengambil pesanan dengan status "Menunggu Konfirmasi"
$query_tinjau = "
    SELECT 
        p.ID_PESANAN, 
        p.JUMLAH_PESANAN, 
        p.TANGGAL_ACARA, 
        p.TOTAL_HARGA, 
        p.STATUS, 
        p.REQUEST, 
        m.NAMA_MENU, 
        m.GAMBAR, 
        c.NAMA_CUSTOMER, 
        c.EMAIL
    FROM PESANAN p
    INNER JOIN PRODUK_MENU m ON p.ID_MENU = m.ID_MENU
    INNER JOIN CUSTOMER c ON p.ID_CUSTOMER = c.ID_CUSTOMER
    WHERE p.STATUS = 'Menunggu Konfirmasi'
";
$result = $conn->query($query_tinjau);  // Eksekusi query

// Cek apakah ada pesanan yang menunggu konfirmasi
if ($result->num_rows > 0) {
    $pesanans = $result->fetch_all(MYSQLI_ASSOC);  // Ambil semua hasil sebagai array
} else {
    $error = "Tidak ada pesanan yang menunggu konfirmasi.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - CateringFood</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigasi -->
<div class="col-md-3 bg-light p-4 sidebar">
    <h1 class="text-center mb-4">Dashboard</h1>
    <ul class="list-unstyled">
        <li><a href="dashboard.php" class="d-block py-2">Dashboard</a></li>
        <li><a href="customer.php" class="d-block py-2">Data Customer</a></li>
        <li><a href="tinjau.php" class="d-block py-2 active">Peninjauan Pemesanan</a></li>
        <li><a href="riwayat.php" class="d-block py-2">Riwayat Pemesanan</a></li>


    <div class="content">
        <div class="admin">
            <h2>Peninjauan Pemesanan #<?= htmlspecialchars($pesanan['ID_PESANAN']) ?> (<?= htmlspecialchars($pesanan['NAMA_CUSTOMER']) ?>)</h2>
            <div class="order-details">
                <p><strong>Menu:</strong> <?= htmlspecialchars($pesanan['NAMA_MENU']) ?></p>
                <p><strong>Jumlah Pesanan:</strong> <?= htmlspecialchars($pesanan['JUMLAH_PESANAN']) ?></p>
                <p><strong>Tanggal Acara:</strong> <?= htmlspecialchars($pesanan['TANGGAL_ACARA']) ?></p>
                <p><strong>Total Harga:</strong> Rp <?= number_format($pesanan['TOTAL_HARGA'], 2, ',', '.') ?></p>
                <p><strong>Permintaan Khusus:</strong> <?= nl2br(htmlspecialchars($pesanan['REQUEST'])) ?></p>
                <p><strong>Nama Customer:</strong> <?= htmlspecialchars($pesanan['NAMA_CUSTOMER']) ?></p>
                <p><strong>Email Customer:</strong> <?= htmlspecialchars($pesanan['EMAIL']) ?></p>
                <p><strong>Status Saat Ini:</strong> <?= htmlspecialchars($pesanan['STATUS']) ?></p>
            </div>

            <!-- Tampilkan error jika ada -->
            <?php if (isset($error)) echo "<div class='notification'>$error</div>"; ?>

            <!-- Form konfirmasi dengan button -->
            <?php if ($pesanan['STATUS'] == 'Menunggu Konfirmasi'): ?>
                <form method="POST">
                    <p>Pilih Status Pemesanan:</p>
                    <button type="submit" name="status" value="Disetujui" class="btn-acc">Disetujui</button>
                    <button type="submit" name="status" value="Ditolak" class="btn-reject">Ditolak</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
