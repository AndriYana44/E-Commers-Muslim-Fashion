<?php  

require_once "../config.php";

$id = $_GET['id'];
$kode = $_POST['kode']; 
$nama = $_POST['nama'];
$kategori = $_POST['kategori'];
$stok = $_POST['stok'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];

edit($id, $kode, $nama, $kategori, $stok, $deskripsi, $harga);

?>