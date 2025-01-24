<?php
include('config.php');
session_start();

// Cek apakah ada parameter pesanan_id di URL
$pesanan_id = isset($_GET['pesanan_id']) ? $_GET['pesanan_id'] : 0;

if ($pesanan_id == 0) {
    // Jika tidak ada ID pesanan, arahkan kembali ke halaman sebelumnya
    header("Location: pesanan.php");
    exit();
}

// Query untuk mengambil data transaksi berdasarkan pesanan_id
$query = "SELECT 
            TRANSAKSI.*, 
            PESANAN.*, 
            CUSTOMER.NAMA_CUSTOMER, 
            PRODUK_MENU.NAMA_MENU, 
            PRODUK_MENU.GAMBAR, 
            ADM.NAMA_ADMIN AS NAMA_ADMIN_PESANAN,  -- Nama admin yang mengonfirmasi pesanan
            ADM.NAMA_ADMIN AS NAMA_ADMIN_TRANSAKSI  -- Nama admin yang memproses transaksi
          FROM TRANSAKSI 
          LEFT JOIN PESANAN ON TRANSAKSI.ID_PESANAN = PESANAN.ID_PESANAN
          LEFT JOIN CUSTOMER ON PESANAN.ID_CUSTOMER = CUSTOMER.ID_CUSTOMER
          LEFT JOIN PRODUK_MENU ON PESANAN.ID_MENU = PRODUK_MENU.ID_MENU
          LEFT JOIN ADM ON TRANSAKSI.ID_ADMIN = ADM.ID_ADMIN  -- JOIN dengan tabel ADM berdasarkan ID_ADMIN di TRANSAKSI
          WHERE TRANSAKSI.ID_PESANAN = ?";

// Siapkan prepared statement untuk menghindari SQL injection
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $pesanan_id);  // 'i' berarti integer
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah transaksi ditemukan
if ($result->num_rows > 0) {
    $transaksi = $result->fetch_assoc();
} else {
    $error = "Transaksi tidak ditemukan.";  // Variabel error didefinisikan disini jika tidak ada transaksi
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Sukses - CateringFood</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @media print {
            .navbar, .footer {
                display: none !important;
            }
        }

        .center {
            text-align: center;
        }
        .order-details img {
            max-width: 150px;
            margin-top: 10px;
        }
        .struk-container {
            width: 80%;
            margin: 0 auto;
        }
        .struk-header {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .struk-footer {
            margin-top: 20px;
            text-align: center;
        }
        .struk-footer button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .struk-footer button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Navigasi -->
<?php include('navbar.php'); ?>

<!-- Transaksi Sukses Section -->
<section class="transaksi-section">
    <div class="struk-container">
        <?php if (isset($transaksi)): ?>
            <div class="struk-header">
                <h2>Struk Pembayaran</h2>
            </div>
            <div class="order-details">
                <p><strong>Nama Pelanggan:</strong> <?php echo htmlspecialchars($transaksi['NAMA_CUSTOMER']); ?></p>
                <p><strong>Menu:</strong> <?php echo htmlspecialchars($transaksi['NAMA_MENU']); ?></p>
                <img src="images/<?php echo htmlspecialchars($transaksi['GAMBAR']); ?>" alt="Gambar Menu">
                <p><strong>Jumlah Pesanan:</strong> <?php echo htmlspecialchars($transaksi['JUMLAH_PESANAN']); ?></p>
                <p><strong>Total Harga:</strong> Rp <?php echo number_format($transaksi['TOTAL_HARGA'], 2, ',', '.'); ?></p>
                <p><strong>Status Pembayaran:</strong> <?php echo htmlspecialchars($transaksi['STATUS_PEMBAYARAN']); ?></p>
                <p><strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars($transaksi['METODE_PEMBAYARAN']); ?></p>
                <p><strong>Virtual Account:</strong> <?php echo htmlspecialchars($transaksi['virtual_account']); ?></p>
                <p><strong>Tanggal Pembayaran:</strong> <?php echo htmlspecialchars($transaksi['TGL_BAYAR']); ?></p>
                <p><strong>Admin Konfirmasi Pesanan:</strong> <?php echo htmlspecialchars($transaksi['NAMA_ADMIN_PESANAN']); ?></p>
            </div>

            <!-- Tombol Cetak -->
            <div class="struk-footer">
                <button onclick="window.print()">Cetak Struk</button>
            </div>
        <?php elseif (isset($error)): ?>
            <!-- Tampilkan error hanya jika ada -->
            <p class="notification error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- Footer -->

</body>
</html>
