<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location:index.php');
    exit;
}

$total_produk        = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM products"))['jml'];
$total_pemasok       = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM suppliers"))['jml'];
$transaksi_hari_ini  = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) as jml FROM sales WHERE DATE(tanggal)=CURDATE()"))['jml'];
$total_penjualan     = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(total) as jml FROM sales"))['jml'];

$stok_habis          = mysqli_query($koneksi, "SELECT * FROM products WHERE stok <= 5 ORDER BY stok ASC");
$penjualan_terakhir  = mysqli_query($koneksi, "SELECT * FROM sales ORDER BY id DESC LIMIT 5");

// Data chart
$sql_chart = mysqli_query($koneksi, "
    SELECT DATE_FORMAT(tanggal,'%M %Y') as bulan, SUM(total) as total 
    FROM sales 
    GROUP BY YEAR(tanggal), MONTH(tanggal) 
    ORDER BY YEAR(tanggal), MONTH(tanggal)
");

$labels = [];
$values = [];
while ($row = mysqli_fetch_assoc($sql_chart)) {
    $labels[] = $row['bulan'];
    $values[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Sistem Penjualan</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
        }

        .card {
        background: linear-gradient(145deg, #ffffff, #ffffffff);
        border-radius: 16px;
        padding: 25px;
        text-align: center;
        font-size: 17px;
        font-weight: 700;
        color: #333;
        box-shadow: 5px 5px 15px #d1d9e6, -5px -5px 15px #ffffff;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        }

        .card:hover {
        transform: translateY(-6px);
        }

        /* Aksen warna di atas */
        .card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        border-radius: 16px 16px 0 0;
        }

        .card.blue::before { background: #3498db; }
        .card.green::before { background: #2ecc71; }
        .card.yellow::before { background: #f1c40f; }
        .card.red::before { background: #e74c3c; }



        table {
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
        <h1>Dashboard</h1>

        <div class="cards">
            <div class="card blue">Produk: <?php echo $total_produk; ?></div>
            <div class="card green">Pemasok: <?php echo $total_pemasok; ?></div>
            <div class="card yellow">Transaksi Hari Ini: <?php echo $transaksi_hari_ini; ?></div>
        </div>

        <h3>Stok Hampir Habis</h3>
        <table>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Stok</th>
            </tr>
            <?php while($s = mysqli_fetch_assoc($stok_habis)){ ?>
            <tr><td><?= $s['kode']; ?></td><td><?= $s['nama']; ?></td><td><?= $s['stok']; ?></td></tr>
            <?php } ?>
        </table>

        <h3>Penjualan Terakhir</h3>
        <table>
            <tr>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($penjualan_terakhir)) { ?>
                <tr>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td>Rp <?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </table>

        <h3>Grafik Penjualan Bulanan</h3>
        <div class="card white">
            <canvas id="chartPenjualan"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('chartPenjualan');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Total Penjualan',
                    data: <?php echo json_encode($values); ?>,
                    backgroundColor: [
                        'rgba(52,152,219,0.7)',
                        'rgba(44,62,80,0.7)',
                        'rgba(52,152,219,0.7)',
                        'rgba(44,62,80,0.7)',
                        'rgba(255,255,255,0.7)'
                    ],
                    borderColor: [
                        'rgba(41,128,185,1)',
                        'rgba(39,55,76,1)',
                        'rgba(41,128,185,1)',
                        'rgba(39,55,76,1)',
                        'rgba(200,200,200,1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
