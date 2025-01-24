<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Produk - CateringApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigasi -->
<?php include('navbar.php'); ?>

<!-- Produk Section -->
<section class="produk-section">
    <div class="produk-container">
        <h2>Menu Pilihan</h2>

        <!-- Form Pencarian -->
        <form method="GET" action="" class="search-form">
            <input type="text" name="search" placeholder="Cari menu..." class="search-input" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="search-btn">Cari</button>
        </form>

        <div class="produk-list">
            <?php
            // Ambil nilai pencarian jika ada
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            // Menampilkan daftar produk makanan dari database dengan filter pencarian
            if (!empty($search)) {
                $sql = "SELECT * FROM PRODUK_MENU WHERE NAMA_MENU LIKE '%" . $conn->real_escape_string($search) . "%'";
            } else {
                // Jika tidak ada pencarian, tampilkan semua produk
                $sql = "SELECT * FROM PRODUK_MENU";
            }

            $result = $conn->query($sql);
            
            // Menampilkan hasil produk
            if ($result->num_rows > 0) {
                while ($produk = $result->fetch_assoc()) {
                    $gambar = !empty($produk['GAMBAR']) ? $produk['GAMBAR'] : 'default.jpg';
                    echo "<div class='produk-item'>
                            <img src='images/{$gambar}' alt='{$produk['NAMA_MENU']}'>
                            <div class='produk-details'>
                                <h3>{$produk['NAMA_MENU']}</h3>
                                <p>{$produk['DESKRIPSI']}</p>
                                <p>Harga: Rp " . number_format($produk['HARGA'], 2, ',', '.') . "</p>
                                <a href='pemesanan.php?menu_id={$produk['ID_MENU']}' class='btn-pesan'>Pesan Sekarang</a>
                            </div>
                          </div>";
                }
            } else {
                echo "<p>Produk tidak ditemukan</p>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>
