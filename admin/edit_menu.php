<?php
include('../config.php');
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_menu'])) {
    $id_menu = $_GET['id_menu'];
    
    // Ambil data menu berdasarkan ID
    $query = "SELECT * FROM PRODUK_MENU WHERE ID_MENU = '$id_menu'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $menu = $result->fetch_assoc();
    } else {
        header("Location: admin_menu.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_menu = $_POST['nama_menu'];
        $deskripsi = $_POST['deskripsi'];
        $harga = $_POST['harga'];
        $gambar = $menu['GAMBAR'];  // Gambar yang lama jika tidak diubah

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $gambar = $_FILES['gambar']['name'];
            $target_dir = "images/";
            $target_file = $target_dir . basename($gambar);

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                // Gambar baru berhasil diupload
            } else {
                $error = "Gagal mengunggah gambar.";
            }
        }

        $query = "UPDATE PRODUK_MENU SET NAMA_MENU = '$nama_menu', DESKRIPSI = '$deskripsi', HARGA = '$harga', GAMBAR = '$gambar' 
                  WHERE ID_MENU = '$id_menu'";

        if ($conn->query($query) === TRUE) {
            header("Location: admin_menu.php");
            exit();
        } else {
            $error = "Gagal mengupdate menu: " . $conn->error;
        }
    }
} else {
    header("Location: admin_menu.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Admin</title>
    <!-- Link ke Bootstrap CSS (CDN) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .admin-menu-section {
            margin-top: 50px;
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
        .img-preview {
            max-width: 150px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Navigasi Admin -->
<?php include('navbar_admin.php'); ?>

<!-- Form Edit Menu -->
<section class="admin-menu-section">
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>Edit Menu</h3>
            </div>
            <div class="card-body">
                <!-- Tampilkan error jika ada -->
                <?php if (isset($error)): ?>
                    <div class="notification error"><?php echo $error; ?></div>
                <?php endif; ?>

                <!-- Form untuk edit menu -->
                <form action="edit_menu.php?id_menu=<?php echo $menu['ID_MENU']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_menu">Nama Menu</label>
                        <input type="text" class="form-control" name="nama_menu" id="nama_menu" value="<?php echo htmlspecialchars($menu['NAMA_MENU']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4" required><?php echo htmlspecialchars($menu['DESKRIPSI']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" class="form-control" name="harga" id="harga" value="<?php echo $menu['HARGA']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="gambar">Gambar (jika ingin mengganti)</label>
                        <input type="file" class="form-control-file" name="gambar" id="gambar">
                        <?php if ($menu['GAMBAR']): ?>
                            <img src="images/<?php echo $menu['GAMBAR']; ?>" class="img-preview" alt="Gambar Menu">
                        <?php endif; ?>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-submit">Update Menu</button>
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
