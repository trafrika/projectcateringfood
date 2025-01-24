<?php
session_start();
include '../config.php'; // Pastikan koneksi ke database sudah terjalin

// Cek jika admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header("location:index.php");
    exit();
}

// Cek jika ada query pencarian
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $query = "SELECT * FROM CUSTOMER WHERE NAMA_CUSTOMER LIKE '%$search%' OR EMAIL LIKE '%$search%' OR ALAMAT LIKE '%$search%'";
} else {
    $query = "SELECT * FROM CUSTOMER";
}

$res = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$res) {
    die("Query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Customer</title>
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (optional) -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .content {
            padding: 20px;
        }
        .table-container {
            margin-top: 20px;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<!-- Navigasi Admin -->
<?php include('navbar_admin.php'); ?>

<!-- Konten Admin -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="content">
                <h2 class="my-4">Daftar Customer</h2>

                <!-- Form Pencarian -->
                <form class="search-form" method="get" action="">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari berdasarkan Nama, Email, atau Alamat...">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Cari</button>
                        </div>
                    </div>
                </form>

                <!-- Tabel Data Customer -->
                <div class="table-container">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($res)) :
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= htmlspecialchars($row['NAMA_CUSTOMER']) ?></td>
                                    <td><?= htmlspecialchars($row['EMAIL']) ?></td>
                                    <td><?= htmlspecialchars($row['ALAMAT']) ?></td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="edit.php?id=<?= $row['ID_CUSTOMER'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <!-- Tombol Hapus -->
                                        <a href="hapus.php?id=<?= $row['ID_CUSTOMER'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus customer ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php 
                            $no++; 
                            endwhile;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS dan Popper.js CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
