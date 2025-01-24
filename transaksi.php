<?php
include('config.php');
session_start();

// Cek apakah ada parameter pesanan_id di URL
$pesanan_id = isset($_GET['pesanan_id']) ? $_GET['pesanan_id'] : 0;

if ($pesanan_id == 0) {
    // Jika tidak ada ID pesanan, arahkan kembali ke halaman sebelumnya
    header("Location: index.php");
    exit();
}

// Cek apakah pesanan sudah diproses dalam tabel TRANSAKSI
$query_check_transaksi = "SELECT * FROM TRANSAKSI WHERE ID_PESANAN = '$pesanan_id' AND STATUS_PEMBAYARAN = 'dibayar'";
$result_check_transaksi = $conn->query($query_check_transaksi);

// Jika transaksi sudah ada, langsung arahkan ke halaman transaksi_sukses.php
if ($result_check_transaksi->num_rows > 0) {
    header("Location: transaksi_sukses.php?pesanan_id=" . $pesanan_id);
    exit();
}

// Ambil data pesanan berdasarkan pesanan_id
$query = "SELECT * FROM PESANAN WHERE ID_PESANAN = '$pesanan_id'";
$result = $conn->query($query);

// Cek apakah pesanan ditemukan
if ($result->num_rows > 0) {
    $pesanan = $result->fetch_assoc();
    
    // Ambil nama menu dan gambar dari tabel PRODUK_MENU
    $menu_id = $pesanan['ID_MENU'];
    $query_menu = "SELECT NAMA_MENU, GAMBAR FROM PRODUK_MENU WHERE ID_MENU = '$menu_id'";
    $result_menu = $conn->query($query_menu);
    
    if ($result_menu->num_rows > 0) {
        $menu = $result_menu->fetch_assoc();
        $nama_menu = $menu['NAMA_MENU'];
        $gambar_menu = $menu['GAMBAR'];
    } else {
        $nama_menu = 'Menu tidak ditemukan';
        $gambar_menu = 'default.jpg'; // Gambar default jika menu tidak ditemukan
    }
    
    // Jika form disubmit untuk konfirmasi pembayaran
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $metode_pembayaran = $_POST['metode_pembayaran'];
        $virtual_account = $_POST['virtual_account'];  // Menangkap virtual_account yang dipilih

        // Ambil total harga dari pesanan
        $jumlah_pembayaran = $pesanan['TOTAL_HARGA'];

        // Ambil tanggal saat ini untuk TGL_BAYAR
        $tgl_bayar = date('Y-m-d'); // Format tanggal yang sesuai: YYYY-MM-DD

        // Ambil ID_ADMIN dari session (misalnya ID_ADMIN yang login)
        $id_admin = $_SESSION['admin_id'];  // Pastikan 'admin_id' diset dalam session login

        // Simpan status pembayaran dan metode pembayaran ke database
        $query_update = "INSERT INTO TRANSAKSI (ID_PESANAN, ID_ADMIN, TGL_BAYAR, STATUS_PEMBAYARAN, METODE_PEMBAYARAN, jumlah_pembayaran, virtual_account) 
                         VALUES ('$pesanan_id', '$id_admin', '$tgl_bayar', 'dibayar', '$metode_pembayaran', '$jumlah_pembayaran', '$virtual_account')";

        if ($conn->query($query_update)) {
            // Jika berhasil, arahkan ke halaman transaksi sukses dengan membawa ID_PESANAN
            header("Location: transaksi_sukses.php?pesanan_id=" . $pesanan_id);
            exit;
        } else {
            $error = "Gagal memproses pembayaran: " . $conn->error;
        }        
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
    <title>Pembayaran - CateringFood</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styling untuk form dan dropdown */
        .transaksi-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .order-details {
            margin-bottom: 20px;
        }

        .produk-item img {
            max-width: 100%;
            border-radius: 8px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        select, input[type="text"], button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Styling untuk dropdown */
        select {
            appearance: none;
            background-color: #fff;
            background-image: url('https://img.icons8.com/ios-filled/50/000000/arrow.png');
            background-repeat: no-repeat;
            background-position: right 10px center;
        }

        select:focus {
            outline: none;
            border-color: #007bff;
        }

        /* Styling untuk input virtual account */
        input[type="text"] {
            background-color: #f7f7f7;
            cursor: not-allowed;
        }

        .notification.error {
            color: red;
            font-size: 16px;
            margin-bottom: 10px;
        }

        /* Styling untuk gambar menu */
        .produk-item {
            text-align: center;
            margin-bottom: 20px;
        }

    </style>
    <script>
        // Fungsi untuk menampilkan kode virtual account berdasarkan metode pembayaran yang dipilih
        function tampilkanVirtualAccount() {
            var metodePembayaran = document.getElementById('metode_pembayaran').value;
            var virtualAccountField = document.getElementById('virtual_account');
            
            switch (metodePembayaran) {
                case 'Transfer Bank - BCA':
                    virtualAccountField.value = '1234567890';
                    break;
                case 'Transfer Bank - Mandiri':
                    virtualAccountField.value = '5432109876';
                    break;
                case 'Transfer Bank - BNI':
                    virtualAccountField.value = '9876543210';
                    break;
                case 'E-Wallet - OVO':
                    virtualAccountField.value = '5558887771';
                    break;
                case 'E-Wallet - GoPay':
                    virtualAccountField.value = '6669998882';
                    break;
                default:
                    virtualAccountField.value = 'Kode Virtual Account tidak tersedia';
            }
        }
    </script>
</head>
<body>

<!-- Navigasi -->
<?php include('navbar.php'); ?>

<!-- Transaksi Section -->
<section class="transaksi-section">
    <div class="transaksi-container">
        <?php if (isset($pesanan)): ?>
            <h2>Konfirmasi Pembayaran</h2>
            <div class="order-details">
                <!-- Menampilkan gambar menu -->
                <div class="produk-item">
                    <img src="images/<?php echo htmlspecialchars($gambar_menu); ?>" alt="<?php echo htmlspecialchars($nama_menu); ?>" width="150">
                </div>
                <p><strong>Menu:</strong> <?php echo htmlspecialchars($nama_menu); ?></p>
                <p><strong>Jumlah Pesanan:</strong> <?php echo htmlspecialchars($pesanan['JUMLAH_PESANAN']); ?></p>
                <p><strong>Total Harga:</strong> Rp <?php echo number_format($pesanan['TOTAL_HARGA'], 2, ',', '.'); ?></p>
            </div>

            <form action="" method="POST">
                <label for="metode_pembayaran"><strong>Metode Pembayaran:</strong></label>
                <select name="metode_pembayaran" id="metode_pembayaran" required onchange="tampilkanVirtualAccount()">
                    <option value="" disabled selected>--- Pilih Metode Bayar ---</option>
                    <option value="Transfer Bank - BCA">🏦 Transfer Bank - BCA</option>
                    <option value="Transfer Bank - Mandiri">🏦 Transfer Bank - Mandiri</option>
                    <option value="Transfer Bank - BNI">🏦 Transfer Bank - BNI</option>
                    <option value="E-Wallet - OVO">📱 E-Wallet - OVO</option>
                    <option value="E-Wallet - GoPay">📱 E-Wallet - GoPay</option>
                </select>
                
                <p><label for="virtual_account"><strong>Virtual Account:</strong></label></p>
                <input type="text" id="virtual_account" name="virtual_account" readonly>

                <button type="submit">Konfirmasi Pembayaran</button>
            </form>

        <?php else: ?>
            <p class="notification error">Pesanan tidak ditemukan.</p>
        <?php endif; ?>

        <?php if (isset($error)) echo "<div class='notification error'>$error</div>"; ?>
    </div>
</section>

<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>
