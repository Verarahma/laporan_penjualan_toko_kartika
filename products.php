<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location:index.php');
    exit;
}

// Ambil data produk beserta nama supplier
$res = mysqli_query($koneksi, "
    SELECT p.*, s.nama AS supplier
    FROM products p
    LEFT JOIN suppliers s ON p.id_supplier = s.id
    ORDER BY p.id DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kelola Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 10px;
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
        }
        .sidebar {
            width: 220px;
            background: #1e1e2f;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 20px;
        }
        .sidebar h2 { 
          color: #fff; 
          margin-bottom: 20px; 
        }
        .sidebar a {
            display: block;
            color: #fff;
            padding: 12px;
            margin: 5px 0;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #19bd94ff;
        }
        .main {
            margin-left: 240px;
            padding: 20px;
        }
        .btn {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
        }
        .btn-success {
            background: #27ae60;
        }
        .btn-success:hover {
            background: #219150;
        }
        .btn-danger {
            background: #e74c3c;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .btn-edit {
            background: #3498db;
        }
        .btn-edit:hover {
            background: #2c80b4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #5a5a5aff;
            color: #ffffffff;
        }
        tr:hover td {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Toko Kartika</h2>
        <p>Halo, <b><?= $_SESSION['user']; ?></b></p>
        <a href="dashboard.php">Dashboard</a>
        <a href="products.php">Produk</a>
        <a href="suppliers.php">Pemasok</a>
        <a href="sales.php">Transaksi</a>
        <a href="reports.php">Laporan</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <h1>Kelola Produk</h1>
        <p>
            <a href="product_add.php" class="btn btn-success">+ Tambah Produk</a>
        </p>

        <table>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Pemasok</th>
                <th>Aksi</th>
            </tr>
            <?php while ($r = mysqli_fetch_assoc($res)) { ?>
                <tr>
                    <td><?= $r['kode']; ?></td>
                    <td><?= $r['nama']; ?></td>
                    <td><?= $r['kategori']; ?></td>
                    <td>Rp <?= number_format($r['harga'], 2, ',', '.'); ?></td>
                    <td><?= $r['stok']; ?></td>
                    <td><?= $r['supplier'] ? $r['supplier'] : 'Produk Sendiri'; ?></td>
                    <td>
                        <a href="product_edit.php?id=<?= $r['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="product_delete.php?id=<?= $r['id']; ?>" 
                           onclick="return confirm('Hapus produk ini?')" 
                           class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php 
          } 
          ?>
        </table>
    </div>
</body>
</html>
