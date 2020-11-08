<?php  

require_once "../config.php";

$id = $_GET['id'];
$kategori = $_POST['kategori'];
edit_kategori($id, $kategori);

alert('kategori.php', 'Kategori berhasil diubah!');

?>