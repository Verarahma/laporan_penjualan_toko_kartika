<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user'])) {
  header('Location:index.php');
  exit;
}

$res = mysqli_query($koneksi, "SELECT * FROM suppliers ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kelola Pemasok</title>
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
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      color: #fff;
    }
    .btn-success { background: #27ae60; }
    .btn-danger  { background: #e74c3c; }
    .btn-edit    { background: #3498db; }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background: #5a5a5aff;
      color: #fff;
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
    <h1>Kelola Pemasok</h1>
    <p><a href="supplier_add.php" class="btn btn-success">+ Tambah Pemasok</a></p>

    <table class="table">
      <tr>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Kontak</th>
        <th>Aksi</th>
      </tr>
      <?php while ($r = mysqli_fetch_assoc($res)) { ?>
        <tr>
          <td><?= htmlspecialchars($r['nama']); ?></td>
          <td><?= htmlspecialchars($r['alamat']); ?></td>
          <td><?= htmlspecialchars($r['kontak']); ?></td>
          <td>
            <a href="supplier_edit.php?id=<?= $r['id']; ?>" class="btn btn-edit">Edit</a>
            <a href="supplier_delete.php?id=<?= $r['id']; ?>" 
               onclick="return confirm('Hapus pemasok ini?')" 
               class="btn btn-danger">Hapus</a>
          </td>
        </tr>
      <?php } ?>
    </table>
  </div>
</body>
</html>
