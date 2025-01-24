<?php
include('../config.php');
session_start();

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Ambil ID Koki dari URL
$id_koki = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id_koki == 0) {
    header("Location: daftar_koki.php");
    exit();
}

// Ambil data koki dari database
$query = "SELECT * FROM KOKI WHERE ID_KOKI = '$id_koki'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $koki = $result->fetch_assoc();
} else {
    header("Location: daftar_koki.php");
    exit();
}

// Proses update data koki
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_koki = $_POST['nama_koki'];
    $spesialis_menu = $_POST['spesialis_menu'];

    // Query untuk update data koki
    $query_update = "UPDATE KOKI SET NAMA_KOKI = '$nama_koki', SPESIALIS_MENU = '$spesialis_menu' WHERE ID_KOKI = '$id_koki'";

    if ($conn->query($query_update)) {
        header("Location: daftar_koki.php");
        exit();
    } else {
        $error = "Gagal memperbarui data koki: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Koki - Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS untuk tampilan lebih menarik dan responsif */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .admin-container {
            width: 70%;
            margin: 30px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        .error {
            color: #d9534f;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 1.1rem;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 12px 20px;
            font-size: 1.1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .admin-container {
                width: 90%;
                padding: 20px;
            }

            button {
                padding: 10px 18px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

<!-- Navigasi Admin -->
<?php include('navbar_admin.php'); ?>

<!-- Form Edit Koki -->
<section class="admin-section">
    <div class="admin-container">
        <h2>Edit Koki</h2>

        <!-- Menampilkan error jika ada -->
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <!-- Form untuk mengedit koki -->
        <form action="edit_koki.php?id=<?php echo $id_koki; ?>" method="POST">
            <label for="nama_koki">Nama Koki</label>
            <input type="text" name="nama_koki" value="<?php echo htmlspecialchars($koki['NAMA_KOKI']); ?>" required>

            <label for="spesialis_menu">Spesialisasi Menu</label>
            <input type="text" name="spesialis_menu" value="<?php echo htmlspecialchars($koki['SPESIALIS_MENU']); ?>" required>

            <button type="submit">Update Koki</button>
        </form>
    </div>
</section>

</body>
</html>
