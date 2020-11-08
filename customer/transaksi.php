<?php  
	
	session_start();
	require_once "../config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Transaksi</title>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/nav.css">
	<link rel="stylesheet" href="../font/css/all.css">
	<link rel="stylesheet" href="../font/fontawesome/css/all.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
	
		<nav class="navbar navbar-expand-lg navbar-light bg-warning">
		  <img src="../images/logo_lestari2.png" width="180" alt="">
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item">
		        <a class="nav-link" href="index.php">Home</a>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Kategori
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a href="index.php" class="dropdown-item">All</a>
		          <?php  
		          	$query = mysqli_query($conn, "SELECT * FROM kategori");
		          	while($data = mysqli_fetch_array($query)) {
		          ?>
		          <a class="dropdown-item" href="index.php?kategori=<?= $data['kategori']; ?>"><?= $data['kategori']; ?></a>
		          <?php } ?>
		        </div>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Kontak</a>
		      </li>
		    </ul>
		    <form class="form-inline my-2 my-lg-0 ml-5" action="" method="post">
		      <input class="form-control form-control mr-sm-2" name="keyword" placeholder="Pencarian" autocomplete="off">
		      <button type="submit" name="cari" class="btn btn-outline-success mr-4">Search</button>
		      <a href="riwayat_transaksi.php?id=<?= $_SESSION['id_user']; ?>" class="mr-4 btn btn-outline-secondary btn-sm">Riwayat transaksi <i class="fa fa-clock-o"></i></a>
		      <div class="user btn-group dropleft mr-4">
			    <a href="#" class="item-user dropdown-toggle text-secondary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <i class="fa fa-user-circle fa-2x"></i>
			    </a>
			    <div class="dropdown-menu">
				  <p class="dropdown-item font-weight-bold text-white bg-dark pb-2 pt-2"><i class="fa fa-user"></i>&nbsp;<?= $_SESSION['nameCustomer']; ?></p>
			      <a class="dropdown-item mt-2" href="#"><i class="fa fa-cog"></i>&nbsp; Setting</a>
			      <a class="dropdown-item text-danger" href="process/logout.php"><i class="fa fa-power-off"></i>&nbsp; Logout</a>
			    </div>
			  </div>
		    </form>
		  </div>
		</nav>

		<div class="nav-custom">
			<div class="brand">
				<i class="text-primary">Muslim </i>&nbsp;<i class="text-danger">Fashion</i>
			</div>
			<form class="form-custom" action="transaksi.php" method="post">
				<?php
					$sql = mysqli_query($conn, "SELECT DISTINCT users.nama, users.id_user, users.tlp, users.alamat, sub_transaksi.nama_barang, sub_transaksi.jumlah, sub_transaksi.total, sub_transaksi.id_trans, sub_transaksi.kode_barang, sub_transaksi.warna FROM sub_transaksi INNER JOIN users ON sub_transaksi.id_user=users.id_user WHERE users.id_user='$_SESSION[id_user]'");
					$dataKeranjang = mysqli_query($conn, "SELECT SUM(total) AS total_pesanan FROM sub_transaksi WHERE id_user='$_SESSION[id_user]'");
					$totalKeranjang = mysqli_fetch_array($dataKeranjang);
				?>
		    	<a href="#" class="keranjang">Rp. <?= number_format($totalKeranjang['total_pesanan']); ?>.0,-<i class="fa fa-shopping-basket"></i></a>
		    	<div class="detail kr bg-light text-success">
			    	<table class="mb-2">
			    		<?php 
			    			foreach($sql as $data) { 
							$query = mysqli_query($conn, "SELECT SUM(jumlah) AS jml FROM sub_transaksi WHERE nama_barang='$data[nama_barang]'");
							$jumlah = mysqli_fetch_array($query);
			    		?>
			    		<tr>
			    			<td><?= $data['nama_barang']; ?> - <?= $jumlah['jml']; ?> = Rp.<?= number_format($data['total']); ?>.0,-</td>
			    			<td><a onClick="return confirm('ingin menghapus chart?');" href="process/batal.php?id=<?= $data['id_trans']; ?>&kode=<?= $data['kode_barang']; ?>&warna=<?= $data['warna']; ?>" class="ml-3 badge badge-danger text-white"> batal</a></td>
			    		</tr>
			    		<?php } ?>
			    	</table>
			    	<i class="font-weight-bold text-success">Total = Rp. <?= number_format($totalKeranjang['total_pesanan']); ?>.0,-</i>
			    	<button class="btn btn-success btn-block btn-sm mt-3" name="tr" type="submit"><i class="fa fa-money"></i> Transaksi</button>
				</div>
		    </form>
		</div>
		<div class="head-cn container text-center">
			<div class="contact mt-4">
				<div class="row">
					<div class="cn1 col-sm-4 text-center">
						<a href="register.php">
							<i class="fa fa-user fa-2x"></i><br>
							<span>Register Anggota</span>
							<p>Mari Bergabung Bersama Kami</p>
						</a>
					</div>
					<div class="cn2 col-sm-4 text-center">
						<a href="cara_belanja.php">
							<i class="fa fa-shopping-cart fa-2x"></i><br>
							<span>Cara Belanja</span>
							<p>Tata cara untuk pembelian dan pembayaran</p>
						</a>
					</div>
					<div class="cn3 col-sm-4 text-center">
						<a href="">
							<i class="fa fa-phone fa-2x"></i><br>
							<span>Hubungi Kami</span>
							<p>0813 8191 5149</p>
						</a>
					</div>
				</div>
			</div>
			<hr class="hr-prd">
			<div class="prd">
				<span>TRANSAKSI</span>
			</div>
		</div>
		
		<div class="container pb-5">
			<div class="row justify-content-center">
				<div class="col-sm-10 mt-2">
					<h4 class="text-dark">Data Customer</h4>
					<?php 
						$sql = mysqli_query($conn, "SELECT * FROM users");
						$d = mysqli_fetch_array($sql);
					?>
					<div class="row">
						<div class="col-sm-6">
							<label class="mt-3" for="nama">Nama</label>
							<input type="text" class="form-control" value="<?= $d['nama']; ?>">
						</div>
						<div class="col-sm-6">
							<label class="mt-3" for="alamat">Alamat</label>
							<input type="text" id="alamat" name="alamat" value="<?= $d['alamat']; ?>" class="form-control">
						</div>
						<div class="col-sm-6">
							<label class="mt-3" for="email">Email</label>
							<input type="email" id="email" class="form-control" name="email" value="<?= $d['email']; ?>">
						</div>
						<div class="col-sm-6">
							<label class="mt-3" for="tlp">No.Tlp</label>
							<input type="number" name="tlp" id="tlp" class="form-control" value="<?= $d['tlp']; ?>">
						</div>
					</div>
					
					<?php  
						$sql = mysqli_query($conn, "SELECT users.email, users.nama, users.tlp, users.alamat, sub_transaksi.nama_barang, sub_transaksi.warna, sub_transaksi.jumlah, sub_transaksi.total, produk.harga, produk.img FROM users INNER JOIN sub_transaksi ON users.id_user=sub_transaksi.id_user INNER JOIN produk ON sub_transaksi.nama_barang=produk.nama WHERE users.id_user='$_SESSION[id_user]'");
					?>
					
					<h4 class="mt-5 text-dark">Detail Pembelian</h4>
					<div class="row">
					<?php  
						while($data = mysqli_fetch_array($sql)) {
					?>
					
						<div class="col-sm-3 ml-3 pb-3 mt-3 mb-3 text-white" style="background-image: url('../images/produk/<?= $data['img']; ?>'); background-repeat: no-repeat; background-size: cover; background-blend-mode: multiply; background-color: rgba(0,0,0,.6);">
							<table>
								<h5 class=" mt-3 font-weight-bold text-white"><?= $data['nama_barang']; ?></h5>
								<img src="../images/produk/<?= $data['img']; ?>" width="80" alt="">
								<tr>
									<td>warna</td>
									<td>&emsp;:&emsp;<?= $data['warna']; ?></td>
								</tr>
								<tr>
									<td>Jumlah</td>
									<td>&emsp;:&emsp;<?= $data['jumlah']; ?></td>
								</tr>
								<tr>
									<td>Harga</td>
									<td>&emsp;:&emsp;<i>Rp.<?= number_format($data['harga']); ?>,0-</i></td>
								</tr>
								<tr>
									<td>Total</td>
									<td>&emsp;=&emsp;<i>Rp.<?= number_format($data['total']); ?>.0-</i></td>
								</tr>
							</table>
						</div>
					<?php } ?>
						<div class="col-sm-12">
							<?php  
								$query = mysqli_query($conn, "SELECT SUM(total) AS total FROM sub_transaksi WHERE id_user='$_SESSION[id_user];'");
								$totalCart = mysqli_fetch_array($query);
							?>
							<h5 class="text-secondary font-weight-bold mt-4"><i class="fa fa-hand-o-right"></i> Total yang harus dibayar : <i class="text-success">Rp.<?= number_format($totalCart['total']); ?>,0-</i></h5>
						</div>
						<div class="col-sm-12 mt-3">
							<?php  
								$nota = 'BRG';
								$mt_rand = mt_rand(0,1000);
								$sub = substr($totalCart['total'], 0);
								$nota = $nota.$sub.'-'.$mt_rand.'TR';
								$status = 'dalam proses';
							?>
							<form action="" method="post">
								<button onClick="return confirm('Melanjutkan Transaksi?');" class="btn btn-outline-success" type="submit" name="transaksi">Konfirmasi Transaksi</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php  
			if(isset($_POST['transaksi'])) {
				
				$query = mysqli_query($conn, "SELECT * FROM sub_transaksi WHERE id_user='$_SESSION[id_user]'");
				if(mysqli_num_rows($query) > 0) {
					while($data = mysqli_fetch_assoc($query)) {
						$result = mysqli_query($conn, "INSERT INTO transaksi SET id_customer='$_SESSION[id_user]', barang='$data[nama_barang]', kode_barang='$data[kode_barang]', warna='$data[warna]', jumlah='$data[jumlah]', total='$data[total]', resi='$nota', tgl=NOW()");
						if($result > 0) {
							mysqli_query($conn, "DELETE FROM sub_transaksi WHERE id_user='$_SESSION[id_user]'");
							mysqli_query($conn, "INSERT INTO konfirmasi SET id_user='$_SESSION[id_user]', resi='$nota', status='$status'");
							alert('index.php', 'Transaksi berhasil diproses!');
						}
					}
				}else{
					alert('index.php', 'Pilih barang terlebih dahulu');
				}
			}
		?>

		<div class="footer mt-5">
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="location">
							<div class="text-center">
								<span class="font-weight-bold text-secondary mb-4 text-center"><i class="fa fa-compass"></i> LESTARI COLLECTION</span>
							</div>
							<div class="mt-4">
								<p>Toko: Setiap Hari Pukul 09.00-16.00, Kecuali Hari Libur Nasional</p>
								<p>Jam Kerja Admin: Senin-Sabtu Pukul 08:00-17:00</p>
								<p>Order via web 24 jam</p>
								<p>METODE PEMBAYARAN HANYA COD (CASH ON DELIVERY)</p>
							</div>
						</div>
					</div>
					<div class="col-sm-4 text-center">
						<div class="maps">
							<span class="font-weight-bold text-secondary text-center"><i class="fa fa-map-marker"></i> MAPS</span>
							<div class="mt-4">
								<iframe width="300" height="200" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d495.5656089924289!2d106.8938560116569!3d-6.454978395330105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ebcd118f442b%3A0x2928c4683db8c7a9!2sToko%20Pakaian%20Lestari!5e0!3m2!1sid!2sid!4v1595924599793!5m2!1sid!2sid" width="600" height="450" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
							</div>
						</div>
					</div>
					<div class="col-sm-4 text-center">
						<span class="ml-5 font-weight-bold text-secondary text-center"><i class="fa fa-car"></i> EKSPEDISI</span>
						<div class="pengiriman ml-5 mt-4">
							<img class="ml-3 mt-3 pl-2 pr-2 bg-white" src="../images/pengiriman/other_j&t.jpg" alt="">
							<img class="ml-3 mt-3 pl-2 pr-2 bg-white" src="../images/pengiriman/other_jne.jpg" alt=""><br>
							<img class="ml-3 mt-3 pl-2 pr-2 bg-white" src="../images/pengiriman/other_sicepat.jpg" alt="">
							<img class="ml-3 mt-3 pl-2 pr-2 bg-white" src="../images/pengiriman/other_tiki.jpg" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="foot">	
			<span>&copy; Copyright 2020 Reversed All Right.</span>
		</div>

	</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="../js/script.js"></script>
</html>