<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$res = mysqli_query($koneksi, "SELECT * FROM suppliers WHERE id = '$id'");
$supplier = mysqli_fetch_assoc($res);

if (isset($_POST['submit'])) {
    $nama   = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];

    mysqli_query($koneksi, "UPDATE suppliers 
                            SET nama = '$nama', 
                                alamat = '$alamat', 
                                kontak = '$kontak' 
                            WHERE id = '$id'");
    header("Location: suppliers.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Pemasok</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap">
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

    .form-container {
      max-width: 600px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
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

    .form-row input,
    .form-row textarea {
      flex: 1;
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-family: 'Poppins','sans-serif';
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
      font-size: 15px;
      min-width: 65px;          /* biar lebar minimalnya sama */
      text-align: center;
      display: inline-block;
    }

    .btn-success {
      background: #27ae60;
    }

    .btn-danger {
      background: #e74c3c;
    }

    .btn:focus,
    .btn:active {
      outline: none;
      box-shadow: none;
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
            <h1>Edit Pemasok</h1>
            <form method="post">
                <div class="form-row">
                    <label>Nama</label>
                    <input type="text" name="nama" value="<?php echo htmlspecialchars($supplier['nama']); ?>" required>
                </div>
                <div class="form-row">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="3"><?php echo htmlspecialchars($supplier['alamat']); ?></textarea>
                </div>
                <div class="form-row">
                    <label>Kontak</label>
                    <input type="text" name="kontak" value="<?php echo htmlspecialchars($supplier['kontak']); ?>">
                </div>
                <div style="text-align:right;">
                    <button type="submit" name="submit" class="btn btn-success">Simpan</button>
                    <a href="suppliers.php" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
