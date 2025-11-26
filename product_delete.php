<?php
session_start();
include 'config/koneksi.php';

if(!isset($_SESSION['user'])){
    header('Location:index.php');
    exit;
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    $cek = mysqli_query($koneksi, "SELECT id FROM sales_detail WHERE id_product='$id' LIMIT 1");

    if(mysqli_num_rows($cek) > 0){
        
        header("Location: products.php?error=Produk tidak bisa dihapus karena sudah ada di transaksi penjualan");
        exit;
    }

    $delete = mysqli_query($koneksi, "DELETE FROM products WHERE id='$id'");

    if($delete){
        header("Location: products.php?msg=deleted");
        exit;
    } else {
        header("Location: products.php?error=Gagal menghapus produk");
        exit;
    }

} else {
    header("Location: products.php");
    exit;
}
?>
