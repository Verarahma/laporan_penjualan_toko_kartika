<?php
session_start();
include 'config/koneksi.php';
if(!isset($_SESSION['user'])){
    header('Location: index.php');
    exit;
}

$from = $_GET['from'] ?? '';
$to   = $_GET['to'] ?? '';

$where = '';
if($from && $to){
    $where = "WHERE DATE(tanggal) BETWEEN '$from' AND '$to'";
}

// ambil detail laporan
$sql = "SELECT s.id, s.tanggal, s.total, sd.id_product, sd.qty, sd.subtotal, p.kode, p.nama 
        FROM sales s 
        JOIN sales_detail sd ON s.id = sd.id_sale 
        JOIN products p ON sd.id_product = p.id 
        $where 
        ORDER BY s.tanggal DESC";
$res = mysqli_query($koneksi, $sql);

// total omzet
$res_total = mysqli_query($koneksi, "SELECT SUM(total) as t FROM sales $where");
$total_all = 0;
if($r2 = mysqli_fetch_assoc($res_total)){
    $total_all = $r2['t'];
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Penjualan</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap">
<style>
  body {
    font-family: 'Poppins', sans-serif;
    margin: 0; padding: 0;
    background: #f4f6f9; color: #333;
  }
  .header {
    background: linear-gradient(to right, #007bff, #00c6ff);
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
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  a { text-decoration: none; color: #007bff; font-weight: bold; }

  form input, form button, .btn {
  padding: 8px 14px;
  margin: 4px;
  border-radius: 6px;
  font-family: inherit;
  font-size: 14px;
}

/* Tombol umum */
.btn {
  cursor: pointer;
  font-weight: bold;
  border: none;
  box-shadow: none;
  outline: none;
  min-width: 110px;         /* lebar seragam */
  text-align: center;
  display: inline-block;
  transition: 0.2s ease-in-out;
}

/* Warna tombol */
.btn-primary {
  background: #007bff;
  color: #fff;
}
.btn-primary:hover {
  background: #0056b3;
}

.btn-print {
  background: #28a745;
  color: #fff;
}
.btn-print:hover {
  background: #218838;
}

/* Penataan container tombol agar sejajar rapi */
form {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 6px;
}

/* Table styling (biar tetap seperti semula) */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  border-radius: 6px;
}
th, td {
  padding: 10px;
  border-bottom: 1px solid #ddd;
  text-align: left;
  border-radius: 2px;
}
th {
  background: #5a5a5aff;
  color: #fff;
}
tr:nth-child(even){ background: #f9f9f9; }
tr:hover { background: #f1f7ff; }

/* Saat print */
@media print {
  body { background: #fff; }
  .container { box-shadow: none; border: none; }
  form, .btn, a { display: none !important; }
  .header { background: #000; color: #fff; }
}

</style>
</head>
<body>
<div class="header">Laporan Penjualan</div>
<div class="container">
  <p><a href="dashboard.php" class="btn">&larr; Dashboard</a></p>

  <form method="get">
    Dari: <input type="date" name="from" value="<?= $from ?>"> 
    Sampai: <input type="date" name="to" value="<?= $to ?>"> 
    <button class="btn btn-primary" type="submit">Filter</button>
    <a class="btn btn-primary" href="export_sales_csv.php?from=<?= $from ?>&to=<?= $to ?>">Export CSV</a>
    <button onclick="window.print()" type="button" class="btn btn-print">Cetak A4</button>
  </form>

  <table>
    <tr>
      <th>ID</th>
      <th>Tanggal</th>
      <th>Kode</th>
      <th>Nama</th>
      <th>Qty</th>
      <th>Subtotal</th>
    </tr>
    <?php while($r=mysqli_fetch_assoc($res)){ ?>
      <tr>
        <td><?= $r['id']; ?></td>
        <td><?= $r['tanggal']; ?></td>
        <td><?= $r['kode']; ?></td>
        <td><?= $r['nama']; ?></td>
        <td><?= $r['qty']; ?></td>
        <td>Rp <?= number_format($r['subtotal'],2,',','.'); ?></td>
      </tr>
    <?php } ?>
    <tr style="font-weight:bold;background:#e9ecef;">
      <td colspan="5">Total  :</td>
      <td>Rp <?= number_format($total_all ?: 0,2,',','.'); ?></td>
    </tr>
  </table>
</div>
</body>
</html>