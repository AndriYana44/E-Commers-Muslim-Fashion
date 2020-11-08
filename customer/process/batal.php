<?php  

require_once "../../config.php";

$id_trans = $_GET['id'];
$kode_barang = $_GET['kode'];
$warna = $_GET['warna'];

$queryTrans = mysqli_query($conn, "SELECT * FROM sub_transaksi WHERE id_trans='$id_trans' AND kode_barang='$kode_barang'");
$queryWarna = mysqli_query($conn, "SELECT * FROM warna WHERE kode_barang='$kode_barang' AND warna='$warna'");
$dataTrans = mysqli_fetch_assoc($queryTrans);
$dataWarna = mysqli_fetch_assoc($queryWarna);

$stokBack = $dataWarna['stok'] + $dataTrans['jumlah'];

$q1 = mysqli_query($conn, "DELETE FROM sub_transaksi WHERE id_trans='$id_trans'");
$q2 = mysqli_query($conn, "UPDATE warna SET stok='$stokBack' WHERE kode_barang='$kode_barang' AND warna='$warna'");

if($q1 == TRUE && $q2 == TRUE) {
	alert('../index.php', 'Chart telah dihapus!');
}

?>