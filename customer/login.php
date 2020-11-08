<?php  

session_start();
require_once "../config.php";

if(isset($_POST['login'])) {
	$email = $_POST['email'];
	$pass = md5($_POST['pass']);
	loginUser($email, $pass);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Form Login</title>
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
		          <?php  
		          	$query = mysqli_query($conn, "SELECT * FROM kategori");
		          	while($data = mysqli_fetch_array($query)) {
		          ?>
		          <a class="dropdown-item" href="#"><?= $data['kategori']; ?></a>
		          <?php } ?>
		        </div>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Kontak</a>
		      </li>
		    </ul>
		    <form class="form-inline my-2 my-lg-0 ml-5" action="" method="post">
		      <input class="form-control form-control mr-sm-2" name="keyword" placeholder="Pencarian" autocomplete="off">
		      <button type="submit" name="cari" class="btn btn-outline-success mr-5">Search</button>
		      <a class="btn btn-primary btn-sm my-2 my-sm-2 mr-3" href="#"><i class="fa fa-sign-in"></i> Login</a>
		    </form>
		  </div>
		</nav>
		<div class="nav-custom">
			<div class="brand">
				<i class="text-primary">Muslim </i>&nbsp;<i class="text-danger">Fashion</i>
			</div>
			<form class="form-custom" action="">
		    	<a href="">Rp. 00,0 <i class="fa fa-shopping-basket"></i></a>
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
				<span>LOGIN</span>
			</div>
		</div>
	</nav>
	
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-sm-4">
				<div class="login">
					<p class="text-center mt-4">Silahkan masukkan Email dan Password Anda untuk proses Login.</p>
					<form action="" method="post">
						<div class="form-group">
							<label for="Email">Email</label>
							<div class="input-group">
					        	<div class="input-group-prepend">
					          		<div class="input-group-text"><i class="fa fa-envelope"></i></div>
					        	</div>
					        	<input type="email" class="form-control" autocomplete="off" autofocus="on" placeholder="Email" name="email" id="Email">
					        </div>
						</div>
						<div class="form-group">
							<label for="pass">Password</label>
							<div class="input-group">
					        	<div class="input-group-prepend">
					          		<div class="input-group-text"><i class="fa fa-key"></i></div>
					        	</div>
								<input type="password" class="form-control" placeholder="Password" name="pass" id="pass">
					        </div>
					        <a href="#" class="forget float-right mb-3 text-danger">Lupa Password</a>
					        <div class="form-group mt-4">
						        <button class="btn btn-block btn-primary" name="login" type="submit">Login</button>
						        <p class="text-center mt-2">Anda belum mendaftar? klik <a href="register.php" class="font-weight-bold">disini</a> untuk register</p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


	<div class="footer mt-5">
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="location">
							<span class="font-weight-bold text-secondary mb-4 text-center"><i class="fa fa-compass"></i> Lestari Collection</span>
							<div class="mt-4">
								<p>Toko: Setiap Hari Pukul 09.00-16.00, Kecuali Hari Libur Nasional</p>
								<p>Jam Kerja Admin: Senin-Sabtu Pukul 08:00-17:00</p>
								<p>Order via web 24 jam</p>
								<p>METODE PEMBAYARAN HANYA COD (CASH ON DELIVERY)</p>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="maps">
							<span class="font-weight-bold text-secondary text-center"><i class="fa fa-map-marker"></i> Maps</span>
							<div class="mt-4">
								<iframe width="300" height="200" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d495.5656089924289!2d106.8938560116569!3d-6.454978395330105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ebcd118f442b%3A0x2928c4683db8c7a9!2sToko%20Pakaian%20Lestari!5e0!3m2!1sid!2sid!4v1595924599793!5m2!1sid!2sid" width="600" height="450" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<span class="ml-5 font-weight-bold text-secondary text-center"><i class="fa fa-paper-lane"></i> Ekspedisi</span>
						<div class="pengiriman ml-5 mt-4">
							<img src="../images/pengiriman/other_j&t.jpg" alt="">
							<img src="../images/pengiriman/other_jne.jpg" alt=""><br>
							<img src="../images/pengiriman/other_sicepat.jpg" alt="">
							<img src="../images/pengiriman/other_tiki.jpg" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="foot">	
			<span>&copy; Copyright 2020 Reversed All Right.</span>
		</div>
</body>
</html>