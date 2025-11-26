<?php include 'config/koneksi.php'; 
    $id=$_GET['id']; mysqli_query($koneksi, "DELETE FROM suppliers WHERE id='$id'"); 
    header('Location: suppliers.php'); 
    exit; 
?>