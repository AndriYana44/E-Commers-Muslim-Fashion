<?php  
require_once "../config.php";

$id = $_GET['id'];
hapus_kategori($id);

header('location: kategori.php');


?>