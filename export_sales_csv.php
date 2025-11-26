<?php
include 'config/koneksi.php';
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$where = '';
if($from && $to){ $where = "WHERE DATE(s.tanggal) BETWEEN '$from' AND '$to'"; }
$sql = "SELECT s.id, s.tanggal, p.kode, p.nama, sd.qty, sd.subtotal FROM sales s JOIN sales_detail sd ON s.id=sd.id_sale JOIN products p ON sd.id_product=p.id $where ORDER BY s.tanggal DESC";
$res = mysqli_query($koneksi, $sql);
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_penjualan.csv');
$out = fopen('php://output', 'w');
fputcsv($out, ['ID','Tanggal','Kode','Nama','Qty','Subtotal']);
while($r=mysqli_fetch_assoc($res)){ fputcsv($out, [$r['id'],$r['tanggal'],$r['kode'],$r['nama'],$r['qty'],$r['subtotal']]); }
exit;
?>