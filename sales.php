<?php
session_start(); 
include 'config/koneksi.php';

if(!isset($_SESSION['user'])){ header('Location: index.php'); exit; }
$res = mysqli_query($koneksi, "SELECT id,kode,nama,harga,stok FROM products WHERE stok>0 ORDER BY nama");

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Transaksi</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <style>


    .select2-container .select2-selection--single {
      height: 38px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 36px;
    }
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .header {
      background: linear-gradient(to right, #0056b3, #00c851);
      color: #fff;
      padding: 15px;
      text-align: center;
      font-size: 22px;
      font-weight: bold;
    }
    .container {
      width: 80%;
      max-width: 900px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    a {
      text-decoration: none;
      color: #0056b3;
      font-weight: bold;
    }
    .form-row {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }
    select, input {
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      flex: 1;
    }
    .btn {
      padding: 8px 16px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    .btn-primary {
      background: #3697ffff;
      color: #fff;
    }
    .btn-primary:hover { background: #0056b3; }
    .btn-success {
      background: #28a745;
      color: #fff;
    }
    .btn-success:hover { background: #218838; }
    .btn-danger {
      background: #dc3545;
      color: #fff;
    }
    .btn-danger:hover { background: #c82333; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background: #5a5a5aff;
      color: #fff;
    }
    tr:nth-child(even) {
      background: #f9f9f9;
    }
  </style>
</head>
<body>
  <div class="header">Transaksi Penjualan</div>
    <div class="container">
      <p><a href="dashboard.php">&larr; Dashboard</a></p>
      <form method="post" action="sale_process.php" target="_blank">
        <div class="form-row">
        <select id="product_select" style="width: 100%;">
            <option value="">-- pilih produk --</option>
            <?php while($p = mysqli_fetch_assoc($res)) { 
              echo '<option value="'.$p['id'].'|'.$p['kode'].'|'.$p['nama'].'|'.$p['harga'].'">'.
                  $p['kode'].' - '.$p['nama'].' (Rp'.number_format($p['harga'],0,',','.').') Stok:'.$p['stok'].'</option>'; 
            } ?>
        </select>
        <input id="qty" type="number" value="1" min="1" class="input">
        <button type="button" class="btn btn-primary" onclick="addItem()">Tambah</button>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="items_body"></tbody>
      </table>
      <br>
      <button class="btn btn-success" type="submit">Simpan Transaksi</button>
    </form>
  </div>
  <script src="assets/js/app.js"></script>
  <script>
$(document).ready(function() {
    $('#product_select').select2({
        placeholder: "-- pilih produk --",
        allowClear: true
    });
});
</script>
</body>
</html>
