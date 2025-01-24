<?php
include('config.php');
session_start();

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Ambil riwayat pemesanan dari tabel PESANAN
$query_riwayat = "SELECT P.ID_PESANAN, P.ID_MENU, P.JUMLAH_PESANAN, P.TOTAL_HARGA, P.STATUS, T.METODE_PEMBAYARAN, T.VIRTUAL_ACCOUNT, T.STATUS_PEMBAYARAN, M.NAMA_MENU, M.GAMBAR 
                  FROM PESANAN P
                  LEFT JOIN TRANSAKSI T ON P.ID_PESANAN = T.ID_PESANAN
                  LEFT JOIN PRODUK_MENU M ON P.ID_MENU = M.ID_MENU
                  WHERE P.ID_CUSTOMER = '$user_id'
                  ORDER BY P.TANGGAL_PESAN DESC";
$result_riwayat = $conn->query($query_riwayat);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - CateringFood</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigasi -->
<?php include('navbar.php'); ?>

<!-- Riwayat Pemesanan -->
<section class="riwayat-section">
    <div class="riwayat-container">
        <h2>Riwayat Pemesanan</h2>
        <?php if ($result_riwayat->num_rows > 0): ?>
            <div class="riwayat-list">
                <?php while ($riwayat = $result_riwayat->fetch_assoc()): ?>
                    <div class="riwayat-item">
                        <div class="produk-item-history">
                            <!-- Menampilkan gambar menu -->
                            <img src="images/<?php echo htmlspecialchars($riwayat['GAMBAR']); ?>" alt="<?php echo htmlspecialchars($riwayat['NAMA_MENU']); ?>" width="150">
                        </div>
                        <div class="detail-item-history">
                            <p><strong>ID Pesanan:</strong> <?php echo htmlspecialchars($riwayat['ID_PESANAN']); ?></p>
                            <p><strong>Menu:</strong> <?php echo htmlspecialchars($riwayat['NAMA_MENU']); ?></p>
                            <p><strong>Jumlah Pesanan:</strong> <?php echo htmlspecialchars($riwayat['JUMLAH_PESANAN']); ?></p>
                            <p><strong>Total Harga:</strong> Rp <?php echo number_format($riwayat['TOTAL_HARGA'], 2, ',', '.'); ?></p>
                            <p><strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars($riwayat['METODE_PEMBAYARAN']); ?></p>
                            <p><strong>Virtual Account:</strong> <?php echo htmlspecialchars($riwayat['VIRTUAL_ACCOUNT']); ?></p>
                            <p><strong>Status Pembayaran:</strong> <?php echo htmlspecialchars($riwayat['STATUS_PEMBAYARAN']); ?></p>
                            <p><strong>Status Pesanan:</strong> <?php echo htmlspecialchars($riwayat['STATUS']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="notification info">Belum ada riwayat pemesanan.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>
