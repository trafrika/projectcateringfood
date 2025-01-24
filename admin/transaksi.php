<?php
include('../config.php');
session_start();

// Cek apakah pengguna admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php"); // Redirect ke halaman login jika tidak admin
    exit();
}

// Ambil semua transaksi
$query = "SELECT t.*, p.ID_PESANAN, p.ID_CUSTOMER, p.TOTAL_HARGA, c.NAMA 
          FROM TRANSAKSI t 
          JOIN PESANAN p ON t.ID_PESANAN = p.ID_PESANAN
          JOIN CUSTOMER c ON p.ID_CUSTOMER = c.ID_CUSTOMER
          ORDER BY t.TGL_BAYAR DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigasi -->
<?php include('navbar.php'); ?>

<!-- Transaksi Section -->
<section class="transaksi-section">
    <div class="transaksi-container">
        <h2>Daftar Transaksi</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Pesanan</th>
                        <th>ID Customer</th>
                        <th>Nama Customer</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Metode Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $row['ID_PESANAN']; ?></td>
                            <td><?php echo $row['ID_CUSTOMER']; ?></td>
                            <td><?php echo htmlspecialchars($row['NAMA']); ?></td>
                            <td>Rp <?php echo number_format($row['TOTAL_HARGA'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['STATUS_PEMBAYARAN']); ?></td>
                            <td><?php echo $row['TGL_BAYAR'] ? date("d-m-Y", strtotime($row['TGL_BAYAR'])) : '-'; ?></td>
                            <td><?php echo htmlspecialchars($row['METODE_PEMBAYARAN']); ?></td>
                        </tr>
                    <?php $no++; endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Belum ada transaksi yang tercatat.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>
