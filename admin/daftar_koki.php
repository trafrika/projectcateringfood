<?php
include('../config.php');
session_start();

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Ambil data koki dari database
$query = "SELECT * FROM KOKI";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Koki - Admin</title>
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
            width: 90%;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        /* Styling button */
        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling untuk tombol Edit dan Hapus */
        td a {
            display: inline-block;
            padding: 8px 16px;
            font-size: 14px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        td a:first-child {
            background-color: #f8c00c; 
            color: black; 
        }

        td a:first-child:hover {
            background-color: #e0a800;
        }

        td a:last-child {
            background-color: #dc3545; 
            color: white; 
        }

        td a:last-child:hover {
            background-color: #c82333; 
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            .btn {
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>

<!-- Navigasi Admin -->
<?php include('navbar_admin.php'); ?>

<!-- Daftar Koki Section -->
<section class="admin-section">
    <div class="admin-container">
        <h2>Daftar Koki</h2>
        
        <!-- Button Tambah Koki -->
        <a href="tambah_koki.php" class="btn">Tambah Koki</a>
        
        <!-- Tabel Daftar Koki -->
        <table>
            <thead>
                <tr>
                    <th>ID Koki</th>
                    <th>Nama Koki</th>
                    <th>Spesialisasi Menu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($koki = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $koki['ID_KOKI'] . "</td>
                                <td>" . $koki['NAMA_KOKI'] . "</td>
                                <td>" . $koki['SPESIALIS_MENU'] . "</td>
                                <td>
                                    <a href='edit_koki.php?id=" . $koki['ID_KOKI'] . "'>Edit</a> 
                                    <a href='hapus_koki.php?id=" . $koki['ID_KOKI'] . "' onclick='return confirm(\"Yakin ingin menghapus koki ini?\")'>Hapus</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data koki.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

</body>
</html>
