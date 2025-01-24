<?php
session_start();  // Memastikan session dimulai

// Cek apakah admin sudah login dan session tersedia
if (!isset($_SESSION['admin_name']) || empty($_SESSION['admin_name'])) {
    // Redirect ke halaman login jika session tidak tersedia
    header('Location: login.php');
    exit();
}

include('../config.php');

// Cek jika ada ID pesanan yang diberikan
$pesanan_id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($pesanan_id == 0) {
    // Jika tidak ada ID pesanan, redirect kembali ke riwayat pemesanan
    header('Location: riwayat.php');
    exit();
}

// Query untuk mengambil data pesanan berdasarkan ID
$query = "
    SELECT PESANAN.*, 
           PRODUK_MENU.NAMA_MENU, 
           CUSTOMER.NAMA_CUSTOMER, 
           ADM.NAMA_ADMIN AS ADMIN_NAMA, 
           TRANSAKSI.STATUS_PEMBAYARAN AS STATUS_PEMBAYARAN, 
           TRANSAKSI.TGL_BAYAR
    FROM PESANAN
    INNER JOIN PRODUK_MENU ON PESANAN.ID_MENU = PRODUK_MENU.ID_MENU
    INNER JOIN CUSTOMER ON PESANAN.ID_CUSTOMER = CUSTOMER.ID_CUSTOMER
    LEFT JOIN ADM ON PESANAN.ID_ADMIN = ADM.ID_ADMIN
    LEFT JOIN TRANSAKSI ON PESANAN.ID_PESANAN = TRANSAKSI.ID_PESANAN
    WHERE PESANAN.ID_PESANAN = ?
";

// Siapkan prepared statement untuk menghindari SQL injection
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $pesanan_id);  // 'i' berarti integer
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah pesanan ditemukan
if ($result->num_rows > 0) {
    $pesanan = $result->fetch_assoc();
} else {
    // Jika tidak ada data ditemukan, redirect kembali
    header('Location: riwayat.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Riwayat Pemesanan - CateringFood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .navbar, .footer, .search-form, .btn, .content-container {
                display: none !important;
            }
            body {
                font-family: Arial, sans-serif;
            }
        }

        .content-container {
            margin-top: 30px;
        }

        .struk-header {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .order-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .order-details p {
            font-size: 18px;
        }

        .order-details strong {
            font-size: 18px;
            color: #333;
        }

        .order-details img {
            max-width: 180px;
            display: block;
            margin: 20px auto;
        }

        .struk-footer {
            text-align: center;
            margin-top: 20px;
        }

        .struk-footer button {
            padding: 12px 30px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .struk-footer button:hover {
            background-color: #0056b3;
        }

        @media print {
            .struk-footer button {
                display: none;
            }

            .order-details {
                background-color: transparent !important;
                padding: 20px;
                border: 2px solid #333;
                margin: 20px;
            }

            .order-details p {
                font-size: 16px !important;
                line-height: 1.6;
                margin: 10px 0;
            }

            .order-details img {
                max-width: 180px !important;
            }
        }
    </style>
</head>
<body>

<!-- Konten -->
<div class="container content-container">
    <div class="struk-header">
        <h2>Struk Riwayat Pemesanan</h2>
    </div>
    
    <div class="order-details">
        <!-- Pastikan bahwa data tidak null sebelum menampilkannya -->
        <?php if (isset($pesanan) && !empty($pesanan)): ?>
            <p><strong>Nama Pelanggan:</strong> <?php echo htmlspecialchars($pesanan['NAMA_CUSTOMER']); ?></p>
            <p><strong>Menu:</strong> <?php echo htmlspecialchars($pesanan['NAMA_MENU']); ?></p>
            <p><strong>Jumlah Pesanan:</strong> <?php echo htmlspecialchars($pesanan['JUMLAH_PESANAN']); ?></p>
            <p><strong>Total Harga:</strong> Rp <?php echo number_format($pesanan['TOTAL_HARGA'], 2, ',', '.'); ?></p>
            <p><strong>Status Pesanan:</strong> <?php echo htmlspecialchars($pesanan['STATUS']); ?></p>
            <p><strong>Status Pembayaran:</strong> <?php echo htmlspecialchars($pesanan['STATUS_PEMBAYARAN']); ?></p>
            <p><strong>Tanggal Acara:</strong> <?php echo htmlspecialchars(date('Y-m-d', strtotime($pesanan['TANGGAL_ACARA']))); ?></p>
            <p><strong>Tanggal Pesan:</strong> <?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($pesanan['TANGGAL_PESAN']))); ?></p>
            <p><strong>Admin Konfirmasi:</strong> <?php echo htmlspecialchars($pesanan['ADMIN_NAMA']); ?></p>
            <p><strong>Tanggal Pembayaran:</strong> <?php echo htmlspecialchars($pesanan['TGL_BAYAR']); ?></p>
        <?php else: ?>
            <p>Data pesanan tidak ditemukan.</p>
        <?php endif; ?>

        

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
