<?php
session_start();
include 'config/koneksi.php';
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$res = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$id'");
$product = mysqli_fetch_assoc($res);

// Proses edit produk
if (isset($_POST['submit'])) {
    $kode   = $_POST['kode'];
    $nama   = $_POST['nama'];
    $harga  = $_POST['harga'];
    $stok   = $_POST['stok'];

    mysqli_query($koneksi, "UPDATE products SET kode='$kode', nama='$nama', harga='$harga', stok='$stok' WHERE id='$id'");
    header("Location: products.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Produk</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    margin: 0;
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
.form-container {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.form-row {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}
.form-row label {
    width: 120px;
    font-weight: 600;
}
.form-row input {
    flex: 1;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-family: 'Inter','sans-serif';
}
.btn {
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    margin-right: 6px;
    cursor: pointer;
    border: none;
    font-size: 14px;
}
.btn-success { background: #27ae60; }
.btn-danger { background: #e74c3c; }
.form-actions { 
    text-align: right; 
    margin-top: 15px; 
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
    <div class="form-container">
     <h1>Edit Produk</h1>
        <form method="post">
            <div class="form-row">
                <label>Kode</label>
                <input type="text" name="kode" value="<?php echo $product['kode']; ?>" required>
            </div>

            <div class="form-row">
                <label>Nama</label>
                <input type="text" name="nama" value="<?php echo $product['nama']; ?>" required>
            </div>

            <div class="form-row">
                <label>Harga</label>
                <input type="number" name="harga" value="<?php echo $product['harga']; ?>" required>
            </div>

            <div class="form-row">
                <label>Stok</label>
                <input type="number" name="stok" value="<?php echo $product['stok']; ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                <a href="products.php" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
