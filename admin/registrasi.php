<?php
session_start();
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_admin = $_POST['nama_admin'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password
    if ($password !== $confirm_password) {
        $error = "Password dan Konfirmasi Password tidak cocok.";
    } else {
        // Enkripsi password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Mengambil foto yang diupload
        $foto_admin = $_FILES['foto_admin']['name'];
        $foto_admin_tmp = $_FILES['foto_admin']['tmp_name'];
        $foto_admin_error = $_FILES['foto_admin']['error'];

        if ($foto_admin_error == 0) {
            // Menentukan folder tujuan untuk menyimpan gambar
            $target_dir = "../uploads/";  // Pastikan folder uploads berada di luar folder admin
            $target_file = $target_dir . basename($foto_admin);

            // Memindahkan file gambar ke folder uploads
            if (move_uploaded_file($foto_admin_tmp, $target_file)) {
                // Query untuk mendaftarkan admin baru beserta foto dan password
                $query = "INSERT INTO ADM (NAMA_ADMIN, NO_TELP, ALAMAT, FOTO_ADMIN, PASSWORD) 
                          VALUES ('$nama_admin', '$no_telp', '$alamat', '$foto_admin', '$password_hash')";  // Simpan hanya nama file

                if ($conn->query($query)) {
                    header('Location: index.php'); // Redirect ke halaman login setelah berhasil registrasi
                    exit;
                } else {
                    $error = "Gagal mendaftar: " . $conn->error;
                }
            } else {
                $error = "Gagal mengupload foto. Pastikan format file valid.";
            }
        } else {
            $error = "Terjadi kesalahan saat mengupload foto.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin</title>
    <!-- Link ke CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height: 100vh; background-color: #f8f9fa;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="text-center mb-4">Registrasi Admin</h2>

                    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama_admin" class="form-label">Nama Admin</label>
                            <input type="text" class="form-control" name="nama_admin" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" name="no_telp" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto_admin" class="form-label">Foto Admin</label>
                            <input type="file" class="form-control" name="foto_admin" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
