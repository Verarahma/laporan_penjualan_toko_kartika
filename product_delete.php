<?php
session_start();
include 'config/koneksi.php';

if(!isset($_SESSION['user'])){
    header('Location:index.php');
    exit;
}

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    // Set produk menjadi nonaktif
    $delete = mysqli_query($koneksi, "UPDATE products SET deleted = 1 WHERE id='$id'");

    if($delete){
        header("Location: products.php?msg=nonaktif");
        exit;
    } else {
        header("Location: products.php?error=Gagal menonaktifkan produk");
        exit;
    }

} else {
    header("Location: products.php");
    exit;
}
?>
