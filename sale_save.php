<?php
session_start();
include 'config/koneksi.php';

// Ambil data POST
$tanggal = date('Y-m-d H:i:s');
$total = $_POST['total'];
$items = $_POST['items']; // array item transaksi

// 1. Simpan ke tabel sales
mysqli_query($koneksi, "INSERT INTO sales (tanggal, total) VALUES ('$tanggal', '$total')");
$id_sale = mysqli_insert_id($koneksi);

// 2. Simpan detail transaksi
foreach($items as $it){
    $id_product = $it['id_product'];
    $qty        = $it['qty'];
    $harga      = $it['harga'];
    $subtotal   = $qty * $harga;

    mysqli_query($koneksi, "
        INSERT INTO sales_detail (id_sale, id_product, qty, harga, subtotal)
        VALUES ('$id_sale', '$id_product', '$qty', '$harga', '$subtotal')
    ");

    // Kurangi stok
    mysqli_query($koneksi, "UPDATE products SET stok = stok - $qty WHERE id='$id_product'");
}

// 3. Buka nota di TAB BARU + redirect halaman lama
echo "
<script>
    // Buka Nota di tab baru
    window.open('nota.php?id=$id_sale', '_blank');

    // Kembali ke halaman transaksi
    window.location.href = 'sales.php?msg=success';
</script>
";
exit;
?>
