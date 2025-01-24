<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    // Proses upload gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($gambar);

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        // Simpan data ke database
        $query = "INSERT INTO PRODUK_MENU (NAMA_MENU, DESKRIPSI, HARGA, GAMBAR)
                  VALUES ('$nama_menu', '$deskripsi', '$harga', '$gambar')";
        if ($conn->query($query)) {
            echo "Produk berhasil ditambahkan!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>
<body>
    <h2>Tambah Produk</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Nama Menu:</label><br>
        <input type="text" name="nama_menu" required><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required></textarea><br>

        <label>Harga:</label><br>
        <input type="text" name="harga" required><br>

        <label>Gambar:</label><br>
        <input type="file" name="gambar" accept="image/*" required><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>