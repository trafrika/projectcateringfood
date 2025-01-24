<?php
session_start();  // Memastikan session dimulai

// Cek apakah admin sudah login dan session tersedia
if (!isset($_SESSION['admin_name']) || empty($_SESSION['admin_name'])) {
    // Redirect ke halaman login jika session tidak tersedia
    header('Location: login.php');
    exit();
}

include('../config.php');

// Cek jika ada query pencarian
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query_riwayat = "
        SELECT PESANAN.*, PRODUK_MENU.NAMA_MENU, CUSTOMER.NAMA_CUSTOMER, ADM.NAMA_ADMIN, TRANSAKSI.STATUS AS STATUS_PEMBAYARAN
        FROM PESANAN
        INNER JOIN PRODUK_MENU ON PESANAN.ID_MENU = PRODUK_MENU.ID_MENU
        INNER JOIN CUSTOMER ON PESANAN.ID_CUSTOMER = CUSTOMER.ID_CUSTOMER
        LEFT JOIN ADM ON PESANAN.ID_ADMIN = ADM.ID_ADMIN
        LEFT JOIN TRANSAKSI ON PESANAN.ID_PESANAN = TRANSAKSI.ID_PESANAN
        WHERE (CUSTOMER.NAMA_CUSTOMER LIKE ? 
           OR PRODUK_MENU.NAMA_MENU LIKE ? 
           OR PESANAN.TANGGAL_PESAN LIKE ?) 
           AND (PESANAN.STATUS != 'Menunggu Konfirmasi' OR PESANAN.ID_ADMIN = ?)
        ORDER BY PESANAN.TANGGAL_PESAN DESC";
    
    $stmt = $conn->prepare($query_riwayat);
    $search_term = "%" . $search . "%";
    $stmt->bind_param("sssi", $search_term, $search_term, $search_term, $_SESSION['admin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query_riwayat = "
        SELECT PESANAN.*, PRODUK_MENU.NAMA_MENU, CUSTOMER.NAMA_CUSTOMER, ADM.NAMA_ADMIN, TRANSAKSI.STATUS_PEMBAYARAN
        FROM PESANAN
        INNER JOIN PRODUK_MENU ON PESANAN.ID_MENU = PRODUK_MENU.ID_MENU
        INNER JOIN CUSTOMER ON PESANAN.ID_CUSTOMER = CUSTOMER.ID_CUSTOMER
        LEFT JOIN ADM ON PESANAN.ID_ADMIN = ADM.ID_ADMIN
        LEFT JOIN TRANSAKSI ON PESANAN.ID_PESANAN = TRANSAKSI.ID_PESANAN
        WHERE PESANAN.STATUS != 'Menunggu Konfirmasi' 
           AND (PESANAN.ID_ADMIN = ? OR PESANAN.STATUS != 'Menunggu Konfirmasi')
        ORDER BY PESANAN.TANGGAL_PESAN DESC";
    $stmt = $conn->prepare($query_riwayat);
    $stmt->bind_param("i", $_SESSION['admin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
}

$no = 1; // Variable counter untuk no urut
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - Admin</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Mengatur jarak antara dashboard dan tabel */
        .content-container {
            margin-top: 30px;
        }
        .table-container {
            margin-top: 30px;
        }
        .form-control {
            width: 300px;
            display: inline-block;
        }
    </style>
</head>
<body>

<!-- Navigasi Admin -->
<?php include('navbar_admin.php'); ?>

<!-- Konten -->
<div class="container content-container">
    <h2 class="text-center mb-4">Riwayat Pemesanan</h2>

    <!-- Form Pencarian -->
    <form method="get" class="d-flex justify-content-between">
        <div class="form-group">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Nama, Menu, atau Tanggal..." value="<?= htmlspecialchars($search) ?>">
        </div>
        <button type="submit" class="btn btn-success ms-2">Cari</button>
    </form>

    <!-- Tabel Riwayat Pemesanan -->
    <?php if ($result && $result->num_rows > 0): ?>
    <div class="table-responsive table-container">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Nama Pelanggan</th>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Tanggal Acara</th>
                    <th>Total Harga</th>
                    <th>Status Pesanan</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Pesan</th>
                    <th>Admin Konfirmasi</th>
                    <th>Cetak</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pesanan = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php echo htmlspecialchars($pesanan['NAMA_CUSTOMER']); ?></td>
                        <td><?php echo htmlspecialchars($pesanan['NAMA_MENU']); ?></td>
                        <td><?php echo htmlspecialchars($pesanan['JUMLAH_PESANAN']); ?></td>
                        <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($pesanan['TANGGAL_ACARA']))); ?></td>
                        <td>Rp <?= number_format($pesanan['TOTAL_HARGA'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($pesanan['STATUS']); ?></td>
                        <td><?php echo htmlspecialchars($pesanan['STATUS_PEMBAYARAN']); ?></td> <!-- Status Pembayaran -->
                        <td>
                            <?php
                            if (!empty($pesanan['TANGGAL_PESAN'])) {
                                echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($pesanan['TANGGAL_PESAN']))); 
                            } else {
                                echo 'Tanggal tidak tersedia';
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($pesanan['NAMA_ADMIN']); ?></td> <!-- Menampilkan nama admin dari tabel ADM -->
                        <td>
                            <!-- Link untuk mencetak berdasarkan ID pesanan -->
                            <a href="cetak_riwayat.php?id=<?php echo $pesanan['ID_PESANAN']; ?>" target="_blank" class="btn btn-primary btn-sm">Cetak</a>
                        </td>
                    </tr>
                <?php $no++; endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <p class="text-center">Tidak ada riwayat pemesanan yang ditemukan.</p>
    <?php endif; ?>

    <!-- Konfirmasi Pesanan -->
    <?php if (isset($_POST['konfirmasi'])): ?>
        <?php
        $id_pesanan = $_POST['id_pesanan'];
        $id_admin = $_SESSION['admin_id'];  // Menggunakan ID admin yang sedang login
        
        // Pastikan hanya admin yang dapat mengonfirmasi pesanan
        $update_query = "UPDATE PESANAN SET STATUS = 'Terkonfirmasi', ID_ADMIN = ? WHERE ID_PESANAN = ? AND STATUS = 'Menunggu Konfirmasi'";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $id_admin, $id_pesanan);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Pesanan berhasil dikonfirmasi.";
        } else {
            echo "Pesanan sudah dikonfirmasi atau ada kesalahan.";
        }
        ?>
    <?php endif; ?>

</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-5">
    <p>&copy; 2024 CateringFood. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>