<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Users</title>
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
						<li><a class="nav__link" href="grapik.php"><i class="fa fa-bar-chart"></i>&emsp;Grafik</a></li>
						<li><a class="nav__link" href="#"><i class="fa fa-users"></i>&emsp;Users</a></li>
						<li><a class="logout" href="../logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-10">
				<h2 class="mt-5"><i class="fa fa-database text-secondary"></i> Daftar User</h2>
				<i class="fa fa-compass text-secondary"> admin / index / users</i>
				<hr>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Alamat</th>
							<th>Email</th>
							<th>No.tlp</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<?php  
						require_once "../config.php";
						$no=1;
						$query = mysqli_query($conn, "SELECT * FROM users");
						while($data = mysqli_fetch_assoc($query)) {
					?>

					<tbody>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= $data['nama']; ?></td>
							<td><?= $data['alamat']; ?></td>
							<td><?= $data['email']; ?></td>
							<td><?= $data['tlp']; ?></td>
							<td>
								<a href="" class="badge badge-danger">Hapus</a>
							</td>
						</tr>
					</tbody>
				<?php } ?>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>