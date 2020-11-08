<?php  

require_once "../config.php";

$id = $_GET['id'];

if(isset($_POST['confirm'])) {
	$resi = $_POST['resi'];
	mysqli_query($conn, "UPDATE konfirmasi SET status='telah diproses' WHERE resi='$resi'");
	header('location: confirm.php?id='.$id);
}

if(isset($_GET['resi'])) {
	mysqli_query($conn, "DELETE FROM konfirmasi WHERE resi='$_GET[resi]'");
	header('location: confirm.php?id='.$id);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Konfirmasi Pesanan</title>
	<link rel="stylesheet" href="../css/nav.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../font/css/all.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="../js/Chart.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
				<div class="nav">
					<ul>
						<li class="text-center mr-5"><a href="#" class="admin"><i class="fa fa-graduation-cap fa-3x"></i>administrator<br><?php date_default_timezone_set('Asia/Jakarta'); echo date('H:i'); ?></a></li><hr>
						<li><a class="nav__link" href="index.php?halaman=1"><i class="fa fa-product-hunt"></i>&emsp;Produk</a></li>
						<li><a class="nav__link" href="kategori.php"><i class="fa fa-filter"></i>&emsp;Kategori</a></li>
						<li><a class="nav__link" href="pemesanan.php"><i class="fa fa-shopping-cart "></i>&emsp;Pemesanan</a></li>
						<li><a class="nav__link" href="#"><i class="fa fa-bar-chart"></i>&emsp;Grafik</a></li>
						<li><a class="nav__link" href="users.php"><i class="fa fa-users"></i>&emsp;Users</a></li>
						<li><a class="logout" href="../logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-10">
				<div>
					<h2 class="mt-5">Detail Pesanan</h2>
					<h5>Konfirmasi pesanan</h5>
					<hr>
				</div>
				<?php
					$id = $_GET['id'];  
					$query = mysqli_query($conn, "SELECT transaksi.resi, transaksi.jumlah, transaksi.barang, transaksi.total, transaksi.tgl, konfirmasi.status, users.nama, produk.img, produk.harga FROM transaksi INNER JOIN konfirmasi ON transaksi.resi=konfirmasi.resi INNER JOIN users ON transaksi.id_customer=users.id_user INNER JOIN produk ON transaksi.barang=produk.nama WHERE users.id_user='$id' ORDER BY transaksi.tgl ASC");
					while($data = mysqli_fetch_array($query)) {
				?>
					<div class="card-group">
					  <div class="card bg-light">
					  	<div class="row">
					    	<div class="col-sm-1">
					    		<img src="../images/produk/<?= $data['img']; ?>" class="card-img-top mt-4 ml-3" alt="...">
					    	</div>
					    	<div class="col-sm-3">
							    <div class="card-body">
							      <p class="card-text"><?= $data['barang']; ?><br>
							      	jumlah - <?= $data['jumlah']; ?><br>
							      	<small>Rp.<?= number_format($data['harga']); ?>,0-/Set</small></p>
							      <p class="card-text"><small class="text-muted"><?= $data['tgl']; ?></small></p>
							    </div>
							</div>
							<div class="col-sm-6">
								<p class="mt-4">Resi : <?= $data['resi']; ?></p>
								<p class="card-text"><small class="text-success">Total - Rp.<?= number_format($data['total']); ?>,0-</small></p>
							</div>
							<div class="col-sm-2 text-center">
								<?php if(strtoupper($data['status']) == strtoupper('dalam proses')) { ?>
									<form action="" method="post">
										<input type="text" name="resi" value="<?= $data['resi']; ?>" hidden>
										<button type="submit" name="confirm" class="btn btn-success btn-sm mt-4">Confirm</button>
										<a href="" class="btn btn-warning btn-sm mt-2">Cancel &times;</a>
									</form>
								<?php }elseif(strtoupper($data['status']) == strtoupper('telah diproses')) { ?>
									<btn class="badge badge-success btn-sm mt-5 disabled">Confirmed <i class="fa fa-check"></i></btn>
									<a onClick="return confirm('Melanjutkan hapus resi ini?');" href="confirm.php?resi=<?= $data['resi']; ?>&id=<?= $id; ?>" class="badge badge-danger btn-sm mt-2">Delete <i class="fa fa-trash"></i></a>
								<?php } ?>
							</div>
						</div>
					  </div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</body>
</html>