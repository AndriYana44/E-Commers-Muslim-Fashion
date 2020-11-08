<?php  
require_once "../config.php";
$kode = $_GET['kode'];

hapus($kode);
header('location: index.php?halaman=1');

?>