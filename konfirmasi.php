<?php
include('config.php');

// Cek apakah ada parameter pesanan_id di URL
$pesanan_id = isset($_GET['pesanan_id']) ? $_GET['pesanan_id'] : 0;

if ($pesanan_id == 0) {
    // Jika tidak ada ID pesanan, arahkan kembali ke halaman sebelumnya
    header("Location: pesanan.php");
    exit();
}

// Menggunakan prepared statement untuk menghindari SQL Injection
$query = $conn->prepare("SELECT * FROM PESANAN WHERE ID_PESANAN = ?");
$query->bind_param("i", $pesanan_id);
$query->execute();
$result = $query->get_result();

// Cek apakah pesanan ditemukan
if ($result->num_rows > 0) {
    $pesanan = $result->fetch_assoc();

    // Ambil nama menu dari tabel PRODUK_MENU
    $menu_id = $pesanan['ID_MENU'];
    $query_menu = $conn->prepare("SELECT NAMA_MENU, GAMBAR FROM PRODUK_MENU WHERE ID_MENU = ?");
    $query_menu->bind_param("i", $menu_id);
    $query_menu->execute();
    $result_menu = $query_menu->get_result();
    
    if ($result_menu->num_rows > 0) {
        $menu = $result_menu->fetch_assoc();
        $nama_menu = $menu['NAMA_MENU'];
        $gambar_menu = $menu['GAMBAR']; // Ambil nama gambar
    } else {
        $nama_menu = 'Menu tidak ditemukan';
        $gambar_menu = 'default.jpg'; // Gambar default jika menu tidak ditemukan
    }

    // Ambil nama pelanggan dari tabel CUSTOMER
    $customer_id = $pesanan['ID_CUSTOMER'];
    $query_customer = $conn->prepare("SELECT NAMA_CUSTOMER FROM CUSTOMER WHERE ID_CUSTOMER = ?");
    $query_customer->bind_param("i", $customer_id);
    $query_customer->execute();
    $result_customer = $query_customer->get_result();

    if ($result_customer->num_rows > 0) {
        $customer = $result_customer->fetch_assoc();
        $nama_customer = $customer['NAMA_CUSTOMER'];
    } else {
        $nama_customer = 'Pelanggan tidak ditemukan';
    }
} else {
    $error = "Pesanan tidak ditemukan.";
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
<?php include('navbar.php'); ?>

<!-- Konfirmasi Section -->
<section class="konfirmasi-section">
    <div class="konfirmasi-container">
        <?php if (isset($pesanan)): ?>
            <h2>Konfirmasi Pesanan</h2>
            <div class="order-details">
                <div class="produk-item">
                    <!-- Menampilkan gambar menu -->
                    <img src="images/<?php echo htmlspecialchars($gambar_menu); ?>" alt="<?php echo htmlspecialchars($nama_menu); ?>" width="150">
                </div>
                <p><strong>Nama Pelanggan:</strong> <?php echo htmlspecialchars($nama_customer); ?></p>
                <p><strong>Menu:</strong> <?php echo htmlspecialchars($nama_menu); ?></p>
                <p><strong>Jumlah Pesanan:</strong> <?php echo htmlspecialchars($pesanan['JUMLAH_PESANAN']); ?></p>
                <p><strong>Tanggal Acara:</strong> <?php echo htmlspecialchars($pesanan['TANGGAL_ACARA']); ?></p>
                <p><strong>Alamat Acara:</strong> <?php echo htmlspecialchars($pesanan['ALAMAT_ACARA']); ?></p>
                <p><strong>Total Harga:</strong> Rp <?php echo number_format($pesanan['TOTAL_HARGA'], 2, ',', '.'); ?></p>
                <p><strong>Permintaan Khusus:</strong> <?php echo nl2br(htmlspecialchars($pesanan['REQUEST'])); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($pesanan['STATUS']); ?></p>
                
                <!-- Tombol Lanjutkan Transaksi hanya jika status pesanan "Disetujui" -->
                <?php if ($pesanan['STATUS'] == 'Disetujui'): ?>
                    <!-- Arahkan ke transaksi.php dengan mengirimkan pesanan_id -->
                    <form action="transaksi.php" method="get">
                        <input type="hidden" name="pesanan_id" value="<?php echo $pesanan_id; ?>">
                        <button type="submit" class="btn btn-primary">Lanjutkan Transaksi</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>Pesanan tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>

<!-- Tambahkan CSS untuk Tombol -->
<style>
/* Gaya untuk tombol Lanjutkan Transaksi */
.btn-primary {
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    font-size: 16px;
}

.btn-primary:hover {
    background-color: #218838;
}
</style>
