<?php
session_start();
include('../config.php');  // Koneksi ke database

// Cek jika admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");  // Redirect ke login jika belum login
    exit();
}

// Menyimpan ID admin ke dalam variabel
$id_admin = $_SESSION['admin_id'];

// Variabel untuk menyimpan daftar pesanan
$pesanans = [];

if (isset($_GET['pesanan_id']) && !empty($_GET['pesanan_id'])) {
    $pesanan_id = $_GET['pesanan_id'];

    // Query untuk mengambil data pesanan berdasarkan ID
    $query = "
        SELECT 
            p.ID_PESANAN, 
            p.JUMLAH_PESANAN, 
            p.TANGGAL_ACARA, 
            p.TOTAL_HARGA, 
            p.STATUS, 
            p.REQUEST, 
            p.ALAMAT_ACARA,  -- Menambahkan kolom ALAMAT_ACARA
            m.NAMA_MENU, 
            m.GAMBAR, 
            c.NAMA_CUSTOMER, 
            c.EMAIL
        FROM PESANAN p
        INNER JOIN PRODUK_MENU m ON p.ID_MENU = m.ID_MENU
        INNER JOIN CUSTOMER c ON p.ID_CUSTOMER = c.ID_CUSTOMER
        WHERE p.ID_PESANAN = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pesanan_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pesanan = $result->fetch_assoc();

        // Proses jika form disubmit untuk mengubah status
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = $_POST['status'];

            // Update status pesanan di database
            $update_query = "UPDATE PESANAN SET STATUS = ?, ID_ADMIN = ? WHERE ID_PESANAN = ?";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("sii", $status, $id_admin, $pesanan_id);
            if ($stmt_update->execute()) {
                // Redirect kembali ke halaman tinjau.php setelah proses update
                header("Location: tinjau.php");  // Setelah berhasil, kembali ke halaman admin
                exit();
            } else {
                $error = "Gagal mengupdate status pesanan.";
            }
        }
    } else {
        $error = "Pesanan tidak ditemukan.";
    }
} else {
    // Jika tidak ada pesanan_id, kita ambil semua pesanan yang menunggu konfirmasi
    $query_tinjau = "
        SELECT 
            p.ID_PESANAN, 
            p.JUMLAH_PESANAN, 
            p.TANGGAL_ACARA, 
            p.TOTAL_HARGA, 
            p.STATUS, 
            p.ALAMAT_ACARA,  -- Menambahkan kolom ALAMAT_ACARA
            m.NAMA_MENU, 
            m.GAMBAR, 
            c.NAMA_CUSTOMER
        FROM PESANAN p
        INNER JOIN PRODUK_MENU m ON p.ID_MENU = m.ID_MENU
        INNER JOIN CUSTOMER c ON p.ID_CUSTOMER = c.ID_CUSTOMER
        WHERE p.STATUS = 'Menunggu Konfirmasi'
    ";
    $result = $conn->query($query_tinjau);

    if ($result->num_rows > 0) {
        $pesanans = $result->fetch_all(MYSQLI_ASSOC);  // Ambil semua hasil sebagai array
    } else {
        $error = "Tidak ada pesanan yang menunggu konfirmasi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peninjauan Pemesanan - CateringFood</title>
    <link rel="stylesheet" href="style.css">  <!-- Pastikan style.css sudah benar -->
    <style>
        /* Custom CSS Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .sidebar {
            background-color: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .sidebar h1 {
            text-align: center;
            color: #5e72e4;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding-left: 0;
        }
        .sidebar ul li {
            margin: 10px 0;
        }
        .sidebar ul li a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover {
            background-color: #f8f9fa;
        }
        .tinjau-section {
            padding-left: 20px;
        }
        .error, .success {
            color: red;
            margin-bottom: 20px;
        }
        .success {
            color: green;
        }
        .order-details {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .order-details p {
            margin: 10px 0;
        }
        .order-details img {
            border-radius: 8px;
            margin-right: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #5e72e4;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn-success, .btn-danger {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-success:hover, .btn-danger:hover {
            opacity: 0.8;
        }

        /* Admin's name display */
        .admin-name {
            font-size: 18px;
            font-weight: bold;
            color: #5e72e4;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Navigasi Admin -->
<?php include('navbar_admin.php'); ?>

    <section class="tinjau-section">
        <h2>Peninjauan Pemesanan</h2>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <?php if (isset($success_message)) echo "<div class='success'>$success_message</div>"; ?>

        <!-- Jika pesanan_id ada, tampilkan form konfirmasi pesanan -->
        <?php if (isset($pesanan)): ?>
            <div class="order-details">
                <div style="display: flex; align-items: center;">
                <img src="../images/<?php echo htmlspecialchars($pesanan['GAMBAR']); ?>" alt="<?php echo htmlspecialchars($pesanan['NAMA_MENU']); ?>" width="150">
                    <div>
                        <p><strong>Nama Customer:</strong> <?php echo htmlspecialchars($pesanan['NAMA_CUSTOMER']); ?></p>
                        <p><strong>Menu:</strong> <?php echo htmlspecialchars($pesanan['NAMA_MENU']); ?></p>
                        <p><strong>Jumlah Pesanan:</strong> <?php echo htmlspecialchars($pesanan['JUMLAH_PESANAN']); ?></p>
                        <p><strong>Tanggal Acara:</strong> <?php echo htmlspecialchars($pesanan['TANGGAL_ACARA']); ?></p>
                        <p><strong>Alamat Acara:</strong> <?php echo htmlspecialchars($pesanan['ALAMAT_ACARA']); ?></p>
                        <p><strong>Total Harga:</strong> Rp <?php echo number_format($pesanan['TOTAL_HARGA'], 2, ',', '.'); ?></p>
                        <p><strong>Permintaan Khusus:</strong> <?php echo nl2br(htmlspecialchars($pesanan['REQUEST'])); ?></p>
                        <p><strong>Nama Customer:</strong> <?php echo htmlspecialchars($pesanan['NAMA_CUSTOMER']); ?></p>
                        <p><strong>Email Customer:</strong> <?php echo htmlspecialchars($pesanan['EMAIL']); ?></p>
                        <p><strong>Status Saat Ini:</strong> <?php echo htmlspecialchars($pesanan['STATUS']); ?></p>
                        <p><strong>Admin:</strong> <?php echo htmlspecialchars($_SESSION['admin_name']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Form konfirmasi dengan button -->
            <form method="POST">
                <p>Pilih Status Pemesanan:</p>
                <button type="submit" name="status" value="Disetujui" class="btn-success">Disetujui</button>
                <button type="submit" name="status" value="Ditolak" class="btn-danger">Ditolak</button>
            </form>
        <?php else: ?>
            <!-- Menampilkan daftar pesanan yang menunggu konfirmasi -->
            <?php if (!empty($pesanans)): ?>
                <table>
                    <tr>
                        <th>No.</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Tanggal Acara</th>
                        <th>Alamat Acara</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    <?php foreach ($pesanans as $index => $pesanan): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($pesanan['NAMA_MENU']) ?></td>
                            <td><?= htmlspecialchars($pesanan['JUMLAH_PESANAN']) ?></td>
                            <td><?= htmlspecialchars($pesanan['TANGGAL_ACARA']) ?></td>
                            <td><?= htmlspecialchars($pesanan['ALAMAT_ACARA']) ?></td>
                            <td>Rp <?= number_format($pesanan['TOTAL_HARGA'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($pesanan['STATUS']) ?></td>
                            <td>
                                <a href="tinjau.php?pesanan_id=<?= $pesanan['ID_PESANAN'] ?>">Tinjau</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>Tidak ada pesanan yang menunggu konfirmasi.</p>
            <?php endif; ?>
        <?php endif; ?>
    </section>
</div>

</body>
</html>

