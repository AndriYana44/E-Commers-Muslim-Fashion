<?php  

require_once '../config.php';
session_start();

$query = mysqli_query($conn, "SELECT kategori FROM kategori");

if($_SESSION['status'] !== 'admin') {
	header('location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Kategori</title>
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
				<div class="text-center">
					<h2 class="mt-5"><i class="fa fa-database text-secondary"></i> Grafik</h2>
					<i class="fa fa-compass text-secondary"> admin / index / grafik</i>
					<p class="mt-3">DETAIL GRAFIK PENJUALAN</p><hr>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<h6 class="text-center mt-3 text-primary">BAR</h6>
						<div style="width: 400px;margin: 0px auto;">
							<canvas id="myChart1"></canvas>
						</div>
					</div>
					<div class="col-sm-6">
						<h6 class="text-center mt-3 text-danger">LINE</h6>
						<div style="width: 400px;margin: 0px auto;">
							<canvas id="myChart2"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<br/>
	<br/>

	<script>
		var ctx = document.getElementById("myChart1").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: [<?php 	while($array = mysqli_fetch_array($query)) {
							echo '"'.$array[0].'",';
						} ?>],
				datasets: [{
					label: '$ bar Data penjualan',
					data: [
					<?php 
					$jumlahPria = mysqli_query($conn,"select * from produk where kategori='pria'");
					$dataPria = mysqli_num_rows($jumlahPria);
					echo $dataPria;
					?>, 
					<?php 
					$jumlahWanita = mysqli_query($conn,"select * from produk where kategori='wanita'");
					$dataWanita = mysqli_num_rows($jumlahWanita);
					echo $dataWanita;
					?>
					],
					backgroundColor: [
					'rgba(255, 99, 132, 0.5)',
					'rgba(54, 162, 235, 0.5)',
					'rgba(255, 206, 86, 0.5)',
					'rgba(75, 192, 192, 0.5)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
	<?php $row = mysqli_num_rows($query); ?>
	<script>
		var ctx = document.getElementById("myChart2").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: [<?php for($i=0; $i<$row; $i++) {
							echo '"'.$i.'",';
						} ?>],
				datasets: [{
					label: '$ line Data penjualan',
					data: [
					<?php 
					$jumlahPria = mysqli_query($conn,"select * from produk where kategori='pria'");
					echo mysqli_num_rows($jumlahPria);
					?>, 
					<?php 
					$jumlahWanita = mysqli_query($conn,"select * from produk where kategori='wanita'");
					echo mysqli_num_rows($jumlahWanita);
					?>
					],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>