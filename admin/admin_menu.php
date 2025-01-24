<?php
include('../config.php');
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Proses pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Ambil data menu dari database berdasarkan pencarian
$query = "SELECT * FROM produk_menu WHERE NAMA_MENU LIKE '%$search%'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Menu</title>
    <!-- Link ke Bootstrap CSS (CDN) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .admin-menu-section {
            margin-top: 30px;
        }
        .card-header {
            background-color: #28a745;
            color: white;
        }
        .table th, .table td {
            text-align: center;
        }
        .table img {
            max-width: 100px;
            border-radius: 8px;
        }
        .btn-edit, .btn-delete {
            width: 80px;
            margin: 0 5px;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input {
            width: 250px;
        }
    </style>
</head>
<body>

<!-- Navigasi Admin -->
<?php include('navbar_admin.php'); ?>

<!-- Menu Section -->
<section class="admin-menu-section">
    <div class="container">
        <!-- Tabel Header -->
        <div class="row mb-4">
            <!-- Fitur Search -->
            <div class="col-md-6">
                <form action="admin_menu.php" method="GET" class="search-box">
                    <input type="text" name="search" class="form-control" placeholder="Cari Menu..." value="<?php echo htmlspecialchars($search); ?>">
                </form>
            </div>
            <!-- Tombol Tambah Menu -->
            <div class="col-md-6 text-right">
                <a href="tambah_menu.php" class="btn btn-success">Tambah Menu</a>
            </div>
        </div>

        <!-- Card untuk Daftar Menu -->
        <div class="card">
            <div class="card-header text-center">
                <h3>Daftar Produk Menu</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID Menu</th>
                            <th>Nama Menu</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($menu = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $menu['ID_MENU']; ?></td>
                            <td><?php echo htmlspecialchars($menu['NAMA_MENU']); ?></td>
                            <td><?php echo htmlspecialchars($menu['DESKRIPSI']); ?></td>
                            <td>Rp <?php echo number_format($menu['HARGA'], 2, ',', '.'); ?></td>
                            <td><img src="../images/<?php echo htmlspecialchars($menu['GAMBAR']); ?>" alt="Gambar Menu"></td>
                            <td>
                                <a href="edit_menu.php?id_menu=<?php echo $menu['ID_MENU']; ?>" class="btn btn-warning btn-edit">Edit</a>
                                <a href="hapus_menu.php?id_menu=<?php echo $menu['ID_MENU']; ?>" class="btn btn-danger btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Link ke Bootstrap JS dan jQuery (CDN) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
