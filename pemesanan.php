<?php
include('config.php');
session_start();

// Cek apakah pengguna sudah login, jika belum arahkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect ke halaman login
    exit();
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['user_id'];

// Cek jika sudah ada pesanan aktif
if (isset($_SESSION['pesanan_id'])) {  
    header("Location: konfirmasi.php?pesanan_id=" . $_SESSION['pesanan_id']);
    exit();
}

// Ambil data menu berdasarkan menu_id dari URL
$menu_id = isset($_GET['menu_id']) ? $_GET['menu_id'] : 0;
$query = "SELECT * FROM PRODUK_MENU WHERE ID_MENU = '$menu_id'";
$result = $conn->query($query);

// Ambil data menu jika ada
if ($result->num_rows > 0) {
    $menu = $result->fetch_assoc();

    // Proses form jika data dikirim
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jumlah_pesanan = $_POST['jumlah_pesanan'];
        $tgl_acara = $_POST['tgl_acara'];
        $alamat_acara = $_POST['alamat_acara'];  // Ambil alamat acara
        $request = isset($_POST['request']) ? $_POST['request'] : '';
        $total_harga = $menu['HARGA'] * $jumlah_pesanan;

        // Simpan ke database pesanan dengan ID pelanggan
        $query_insert = "INSERT INTO PESANAN (ID_MENU, ID_CUSTOMER, JUMLAH_PESANAN, TANGGAL_ACARA, TOTAL_HARGA, REQUEST, STATUS, ALAMAT_ACARA) 
                        VALUES ('$menu_id', '$user_id', '$jumlah_pesanan', '$tgl_acara', '$total_harga', '$request', 'Menunggu Konfirmasi', '$alamat_acara')";

        if ($conn->query($query_insert)) {
            $_SESSION['pesanan_id'] = $conn->insert_id; // Simpan ID pesanan ke sesi
            header("Location: konfirmasi.php?pesanan_id=" . $_SESSION['pesanan_id']);
            exit();
        } else {
            $error = "Gagal menyimpan pesanan: " . $conn->error;
        }
    }
} else {
    $error = "Menu tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - CateringFood</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigasi -->
<?php include('navbar.php'); ?>

<!-- Pemesanan Section -->
<section class="pemesanan-section">
    <div class="pemesanan-container">
        <?php if (isset($menu)): ?>
            <h2>Pesan Menu: <?php echo htmlspecialchars($menu['NAMA_MENU']); ?></h2>
            <div class="produk-item">
                <img src="images/<?php echo htmlspecialchars($menu['GAMBAR']); ?>" alt="<?php echo htmlspecialchars($menu['NAMA_MENU']); ?>">
                <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($menu['DESKRIPSI']); ?></p>
                <p><strong>Harga:</strong> Rp <?php echo number_format($menu['HARGA'], 2, ',', '.'); ?></p>
            </div>

            <?php if (isset($error)) echo "<div class='notification'>$error</div>"; ?>

            <form action="" method="POST">
                <label for="jumlah_pesanan">Jumlah Pesanan:</label>
                <input type="number" name="jumlah_pesanan" min="1" required>

                <label for="tgl_acara">Tanggal Acara:</label>
                <input type="date" name="tgl_acara" required>

                <label for="alamat_acara">Alamat Acara:</label>
                <textarea name="alamat_acara" rows="4" required></textarea>

                <label for="request">Permintaan Khusus:</label>
                <textarea name="request" rows="4"></textarea>
                
                <button type="submit">Proses Pesanan</button>
            </form>

        <?php else: ?>
            <p>Menu tidak ditemukan.</p>
        <?php endif; ?>

        <!-- Riwayat Pesanan yang Menunggu Konfirmasi -->
        <h3>Riwayat Pesanan Anda</h3>
        <?php
        $query_riwayat = "SELECT PESANAN.*, PRODUK_MENU.NAMA_MENU 
                          FROM PESANAN 
                          INNER JOIN PRODUK_MENU ON PESANAN.ID_MENU = PRODUK_MENU.ID_MENU 
                          WHERE PESANAN.ID_CUSTOMER = '$user_id' AND PESANAN.STATUS = 'Menunggu Konfirmasi'";
        $result_riwayat = $conn->query($query_riwayat);

        if ($result_riwayat->num_rows > 0) {
            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>";
            $no = 1;
            while ($row = $result_riwayat->fetch_assoc()) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['NAMA_MENU']}</td>
                        <td>{$row['JUMLAH_PESANAN']}</td>
                        <td>Rp " . number_format($row['TOTAL_HARGA'], 2, ',', '.') . "</td>
                        <td>{$row['STATUS']}</td>
                      </tr>";
                $no++;
            }
            echo "</tbody>
                </table>";
        } else {
            echo "<p>Belum ada pesanan yang menunggu konfirmasi.</p>";
        }
        ?>
    </div>
</section>

<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>
