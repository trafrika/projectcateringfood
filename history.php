<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - CateringApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigasi -->
<?php include('navbar.php'); ?>

<!-- Riwayat Pemesanan Section -->
<section class="history-section">
    <div class="history-container">
        <h2>Riwayat Pemesanan Anda</h2>

        <?php
        // Ambil data pemesanan berdasarkan ID_USER
        $user_id = 1; // Ganti dengan ID pengguna yang sesuai (misalnya dari sesi login)
        $result = $conn->query("SELECT * FROM PEMESANAN WHERE ID_USER = $user_id ORDER BY TGL_ACARA DESC");

        if ($result->num_rows > 0):
            while ($pesanan = $result->fetch_assoc()):
        ?>
                <div class="history-item">
                    <h3><?= $pesanan['NAMA_MENU'] ?></h3>
                    <p>Jumlah: <?= $pesanan['JUMLAH'] ?></p>
                    <p>Tanggal Acara: <?= $pesanan['TGL_ACARA'] ?></p>
                    <p>Status: <?= $pesanan['STATUS'] ?></p>
                    <p><a href="transaksi.php?id=<?= $pesanan['ID_PESANAN'] ?>">Lihat Transaksi</a></p>
                </div>
        <?php
            endwhile;
        else:
            echo "<p>Belum ada riwayat pemesanan.</p>";
        endif;
        ?>
    </div>
</section>

<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>
