<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user'])) {
  header('Location: index.php');
  exit;
}

$ids  = $_POST['id_product'] ?? [];
$qtys = $_POST['qty'] ?? [];

if (empty($ids) || empty($qtys)) {
  header('Location: sales.php');
  exit;
}

// Hitung total transaksi
$total = 0;
foreach ($ids as $i => $idp) {
  $q = mysqli_query($koneksi, "SELECT harga, stok FROM products WHERE id = '$idp'");
  $p = mysqli_fetch_assoc($q);

  $qty = intval($qtys[$i]);
  if ($qty <= 0) $qty = 1;

  $subtotal = $p['harga'] * $qty;
  $total   += $subtotal;
}

// Simpan ke tabel sales
mysqli_query($koneksi, "INSERT INTO sales (total) VALUES ('$total')");
$id_sale = mysqli_insert_id($koneksi);

// Simpan detail penjualan dan update stok
foreach ($ids as $i => $idp) {
  $q = mysqli_query($koneksi, "SELECT harga, stok FROM products WHERE id = '$idp'");
  $p = mysqli_fetch_assoc($q);

  $qty      = intval($qtys[$i]);
  $subtotal = $p['harga'] * $qty;

  mysqli_query($koneksi, "
    INSERT INTO sales_detail (id_sale, id_product, qty, subtotal)
    VALUES ('$id_sale', '$idp', '$qty', '$subtotal')
  ");

  mysqli_query($koneksi, "UPDATE products SET stok = stok - $qty WHERE id = $idp");
}

// Arahkan ke halaman nota
header("Location: nota.php?id=$id_sale");
exit;
?>
