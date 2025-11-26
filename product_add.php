<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location:index.php');
    exit;
}

$kategoriRes = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM products ORDER BY kategori ASC");
$supplierRes = mysqli_query($koneksi, "SELECT id, nama FROM suppliers ORDER BY nama ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode        = $_POST['kode'];
    $nama        = $_POST['nama'];
    $kategori    = !empty($_POST['kategori']) ? $_POST['kategori'] : $_POST['kategori_baru'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    $id_supplier = !empty($_POST['id_supplier']) ? $_POST['id_supplier'] : "NULL";

    $sql = "INSERT INTO products (kode, nama, kategori, harga, stok, id_supplier)
            VALUES ('$kode', '$nama', '$kategori', '$harga', '$stok', $id_supplier)";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        header('Location: products.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Produk</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f0f2f5;
            display: flex;
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
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            min-height: 100vh;
        }
        form {
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: 600;
        }
        input, select {
            width: 100%;
            box-sizing: border-box; /* biar padding & border dihitung dalam lebar total */
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        small {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #555;
        }
        
        .btn {
            padding: 8px 20px;        /* samakan jarak dalam tombol */
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            margin-right: 6px;
            cursor: pointer;
            border: none;
            box-shadow: none;
            outline: none;
            font-size: 16px;
            min-width: 48px;          /* biar lebar minimalnya sama */
            text-align: center;
            display: inline-block;
         }
        .btn-success {
            background: #27ae60;
        }
        .btn-success:hover {
            background: #1f8b4d;
        }
        .btn-danger {
            background: #e74c3c;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
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
        <form method="post">
            <h1>Tambah Produk</h1>

            <label>Kode Produk</label>
            <input type="text" name="kode" required>

            <label>Nama Produk</label>
            <input type="text" name="nama" required>

            <label>Kategori</label>
            <select name="kategori">
                <option value="">-- Pilih Kategori --</option>
                <?php while ($k = mysqli_fetch_assoc($kategoriRes)) { ?>
                    <option value="<?= $k['kategori']; ?>"><?= $k['kategori']; ?></option>
                <?php } ?>
            </select>

            <small>Atau tambahkan baru:</small>
            <input type="text" name="kategori_baru" placeholder="Kategori Baru">

            <label>Harga</label>
            <input type="number" name="harga" required>

            <label>Stok</label>
            <input type="number" name="stok" required>

            <label>Pemasok (opsional)</label>
            <select name="id_supplier">
                <option value="">-- Produk Sendiri --</option>
                <?php while ($s = mysqli_fetch_assoc($supplierRes)) { ?>
                    <option value="<?= $s['id']; ?>"><?= $s['nama']; ?></option>
                <?php } ?>
            </select>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="products.php" class="btn btn-danger">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
