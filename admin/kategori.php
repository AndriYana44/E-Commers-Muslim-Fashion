<?php  

require_once "../config.php";
session_start();

$query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");
$row = mysqli_num_rows($query);

if(isset($_POST['add'])) {
	tambah_kategori($_POST['kategori']);
}

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
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
				<div class="nav">
					<ul>
						<li class="text-center mr-5"><a href="#" class="admin"><i class="fa fa-graduation-cap fa-3x"></i>administrator<br><?php date_default_timezone_set('Asia/Jakarta'); echo date('H:i'); ?></a></li><hr>
						<li><a class="nav__link" href="index.php?halaman=1"><i class="fa fa-product-hunt"></i>&emsp;Produk</a></li>
						<li><a class="nav__link" href="#"><i class="fa fa-filter"></i>&emsp;Kategori</a></li>
						<li><a class="nav__link" href="pemesanan.php"><i class="fa fa-shopping-cart "></i>&emsp;Pemesanan</a></li>
						<li><a class="nav__link" href="grapik.php"><i class="fa fa-bar-chart"></i>&emsp;Grafik</a></li>
						<li><a class="nav__link" href="users.php"><i class="fa fa-users"></i>&emsp;Users</a></li>
						<li><a class="logout" href="../logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-5">
				<h2 class="mt-5"><i class="fa fa-database text-secondary"></i> Daftar Kategori</h2>
				<i class="fa fa-compass text-secondary"> admin / index / kategori</i>
				<hr>
				<form action="" method="post">
					<button name="tambah" type="submit" class="btn btn-primary btn-sm mb-3"><i class="fa fa-plus"></i> Tambah Kategori</button>
				</form>
				<table class="table table-hover table-striped table-sm">
					<thead class="bg-warning">
						<tr class="table-head">
							<th class="text-center">No</th>
							<th class="pl-5">Kategori</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<?php  
						$no=1;
						foreach($query AS $key) :
					?>
					<tbody>
						<tr>
							<td class="text-center"><?= $no; ?></td>
							<td class="pl-5"><?= $key['kategori']; ?></td>
							<td class="text-center">
								<a href="#" type="button" data-toggle="modal" data-target="#kategori<?= $key['id_kategori']; ?>" class="badge badge-warning">Edit</a>
								<a onClick="return confirm('Apakah anda ingin menghapus data ini (<?= $key['kategori']; ?>) ?')" href="hapus_kategori.php?id=<?= $key['id_kategori']; ?>" class="badge badge-danger">Delete</a>
							</td>
						</tr>
					</tbody>
					<div class="modal fade" id="kategori<?= $key['id_kategori']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
					      </div>
					      <form action="edit_kategori.php?id=<?= $key['id_kategori']; ?>" method="post">
						      <div class="modal-body">
						        <div class="input-group mb-3">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">Kategori</span>
								  </div>
									<input type="text" class="form-control" value="<?= $key['kategori']; ?>" name="kategori" aria-label="Username" aria-describedby="basic-addon1" required autocomplete="off">
								</div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
						      </div>
					  	  </form>
					    </div>
					  </div>
					</div>
					<?php  
						$no++;
						endforeach;
					?>
				</table>
				<i class="fa fa-hand-o-right mb-3 text-secondary">&emsp;jumlah produk : <?= $row; ?></i>
			</div>
			<?php  
				if(isset($_POST['tambah'])) {
			?>
			<div class="col align-self-end mt-5">
				<h4 class="text-center"><i class="fa fa-plus-circle text-secondary"> Tambah Kategori</i></h4>
				<form action="" method="post">
					<div class="form-group mt-5">
					    <label for="exampleFormControlInput1" class="text-success">Nama Kategori</label>
					    <input type="text" name="kategori" class="form-control text-info" autofocus autocomplete="off" placeholder="..." required>
					</div>
					<div class="form-group">
						<button class="btn btn-outline-success btn-sm" name="add">Tambah</button>
						<a href="kategori.php" class="btn btn-danger btn-sm text-warning">Cancel</a>
					</div>
				</form>
			</div>
			<?php } ?>
		</div>
	</div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>