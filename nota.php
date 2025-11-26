<?php
include 'config/koneksi.php';
$id_sale = $_GET['id'];
$sale = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM sales WHERE id='$id_sale'"));
$detail = mysqli_query($koneksi, "
  SELECT sd.*, p.nama, p.harga 
  FROM sales_detail sd 
  JOIN products p ON sd.id_product=p.id 
  WHERE sd.id_sale='$id_sale'
");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Nota Pesanan - Toko Kartika</title>
  <style>
    * {
      font-family: "Courier New", monospace;
      font-size: 14px;
    }
    body {
      background: #f8f8f8;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    .nota {
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 20px;
      width: 320px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .nota h2 {
      text-align: center;
      margin: 0;
      font-size: 20px;
      font-weight: bold;
    }
    .nota small {
      display: block;
      text-align: center;
      margin: 4px 0 10px;
    }
    .line {
      border-bottom: 1px dashed #000;
      margin: 6px 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table td {
      padding: 2px 0;
      vertical-align: top;
    }
    td:nth-child(1) {
      width: 50%;
    }
    td:nth-child(2) {
      width: 25%;
      text-align: center;
    }
    td:nth-child(3) {
      width: 25%;
      text-align: right;
    }
    .total {
      margin-top: 10px;
      text-align: right;
      font-weight: bold;
      font-size: 15px;
    }
    .footer {
      text-align: center;
      margin-top: 15px;
      font-size: 13px;
    }
    @media print {
      body {
        background: none;
      }
      .nota {
        box-shadow: none;
        border: none;
      }
    }
  </style>
</head>
<body>
  <div class="nota">
    <h2>Toko Kartika</h2>
    <small>Ds. Kenjer 06/05, Kertek, Wonosobo</small>
    <div class="line"></div>
    <small>Tanggal: <?= date('d-m-Y H:i', strtotime($sale['tanggal'])) ?></small>
    <div class="line"></div>

    <table>
      <?php $total=0; while($r=mysqli_fetch_assoc($detail)){ 
        $total += $r['subtotal']; ?>
        <tr>
          <td><?= htmlspecialchars($r['nama']) ?></td>
          <td><?= $r['qty'] ?> x <?= number_format($r['harga']) ?></td>
          <td><?= number_format($r['subtotal']) ?></td>
        </tr>
      <?php } ?>
    </table>

    <div class="line"></div>
    <div class="total">Total: Rp <?= number_format($total) ?></div>
    <div class="line"></div>

    <div class="footer">
      Terima kasih atas kunjungan Anda!<br>
    </div>
  </div>

  <script>
    setTimeout(function() {
        window.print();
    }, 500);
  </script>
</body>
</html>
