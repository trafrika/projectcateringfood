<?php
include('../config.php');
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    
    // Proses upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "images/";
        $target_file = $target_dir . basename($gambar);

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Gambar berhasil diupload
        } else {
            $error = "Gagal mengunggah gambar.";
        }
    } else {
        $gambar = null;  // Jika tidak ada gambar yang di-upload
    }

    // Simpan data menu ke database
    $query = "INSERT INTO PRODUK_MENU (NAMA_MENU, DESKRIPSI, HARGA, GAMBAR) 
              VALUES ('$nama_menu', '$deskripsi', '$harga', '$gambar')";

    if ($conn->query($query) === TRUE) {
        header("Location: admin_menu.php");
        exit();
    } else {
        $error = "Gagal menambahkan menu: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Admin</title>
    <!-- Link ke Bootstrap CSS (CDN) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .admin-menu-section {
            margin-top: 30px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #28a745;
            color: white;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control, .btn {
            border-radius: 0.375rem;
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
        }
        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Navigasi Admin -->
<?php include('navbar_admin.php'); ?>

<!-- Form Tambah Menu -->
<section class="admin-menu-section">
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>Tambah Menu Baru</h3>
            </div>
            <div class="card-body">
                <!-- Tampilkan error jika ada -->
                <?php if (isset($error)): ?>
                    <div class="notification error"><?php echo $error; ?></div>
                <?php endif; ?>

                <!-- Form untuk tambah menu -->
                <form action="tambah_menu.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_menu">Nama Menu</label>
                        <input type="text" class="form-control" name="nama_menu" id="nama_menu" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" class="form-control" name="harga" id="harga" required>
                    </div>

                    <div class="form-group">
                        <label for="gambar">Gambar</label>
                        <input type="file" class="form-control-file" name="gambar" id="gambar">
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-submit">Tambah Menu</button>
                    </div>
                </form>
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
