<?php  

session_start();
require_once "../config.php";

$halaman 	= 5;
$page 		= isset($_GET['halaman'])? (int)$_GET["halaman"]:1;
$mulai 		= ($page>1) ? ($page * $halaman) - $halaman : 0;
$query 		= mysqli_query($conn, "SELECT * FROM produk ORDER BY kategori ASC LIMIT $mulai, $halaman");
$sql 		= mysqli_query($conn, "SELECT * FROM produk ORDER BY kode_produk ASC");
$total 		= mysqli_num_rows($sql);
$pages 		= ceil($total/$halaman);
$last_query = mysqli_query($conn, "SELECT kode_produk FROM produk WHERE id_produk IN(SELECT MAX(id_produk) FROM produk)");
$last_array = mysqli_fetch_array($last_query);
$last_data 	= $last_array[0];

if(isset($_POST['tambah']) ) {
	$nama 		= htmlspecialchars($_POST['nama']); 
	$kategori 	= htmlspecialchars($_POST['kategori']); 
	$stok 		= htmlspecialchars($_POST['stok']); 
	$deskripsi 	= htmlspecialchars($_POST['deskripsi']);
	$harga 		= htmlspecialchars($_POST['harga']);
	$kode 		= htmlspecialchars($_POST['kode']);
	$sql = mysqli_query($conn, "SELECT kode_produk FROM produk");
	$cek = mysqli_fetch_array($sql);
	if($cek['kode_produk'] == $kode) {
		alert('index.php?halaman=1', 'Kode Produk Sudah ada!');
	}else {
		foreach($_POST['warna'] AS $warna) {
			mysqli_query($conn, "INSERT INTO warna SET warna='$warna', kode_barang='$kode'");
		}

		tambah($kode, $nama, $kategori, $stok, $deskripsi, $harga);
	}
}

if(isset($_POST['addColor'])) {
	$kode = $_POST['kode'];
	$warna = $_POST['warna'];
	$stok = $_POST['stok'];
	
	addColor($kode, $warna, $stok);
}

if(isset($_POST['cari']) ) {
	$key = $_POST['keyword'];
	$query = mysqli_query($conn, "SELECT * FROM produk WHERE nama LIKE '%$key%' OR kode_produk LIKE '%$key%' OR kategori LIKE '%$key%' ORDER BY id_produk ASC LIMIT $mulai, $halaman");
}

if($_SESSION['status'] !== 'admin') {
	header('location: ../index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Produk</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/nav.css">
	<link rel="stylesheet" href="../font/fontawesome/css/all.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-sm-2">
				<div class="nav">
					<ul>
						<li class="text-center mr-5"><a href="#" class="admin"><i class="fa fa-graduation-cap fa-3x"></i>administrator<br><?php date_default_timezone_set('Asia/Jakarta'); echo date('H:i'); ?></a></li><hr>
						<li><a class="nav__link" href="#"><i class="fa fa-product-hunt"></i>&emsp;Produk</a></li>
						<li><a class="nav__link" href="kategori.php"><i class="fa fa-filter"></i>&emsp;Kategori</a></li>
						<li><a class="nav__link" href="pemesanan.php"><i class="fa fa-shopping-cart "></i>&emsp;Pemesanan</a></li>
						<li><a class="nav__link" href="grapik.php"><i class="fa fa-bar-chart"></i>&emsp;Grafik</a></li>
						<li><a class="nav__link" href="users.php"><i class="fa fa-users"></i>&emsp;Users</a></li>
						<li><a class="logout" href="../logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
					</ul>
				</div>
			</div>
			<div class="col-sm-10">
				<h2 class="mt-5"><i class="fa fa-database text-secondary"></i> Daftar Produk</h2>
				<i class="fa fa-compass text-secondary"> admin / index / produk</i>
				<hr>
				<div class="row">
					<div class="col-sm-8">
						<button name="tambah" type="submit" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i> Tambah Data</button>
					</div>
					<div class="col-sm-4">
						<form class="form-inline my-2 my-lg-0" action="" method="post">
							<input class="form-control form-control-sm mr-2" type="search" placeholder="Search.." aria-label="Search" autofocus="on" autocomplete="off" name="keyword">
							<button class="btn btn-outline-success btn-sm my-2 my-sm-0" name="cari" type="submit">Search</button>
						</form>
					</div>
				</div>
				<table class="table table-striped table-hover table-bordered table-sm">
					<thead class="">
						<tr class="bg-info table-head">
							<th class="text-center" width="20">No</th>
							<th class="text-center" width="100">Gambar</th>
							<th class="pl-4" width="100">Nama Barang</th>
							<th class="pl-4" width="100">Kategori</th>
							<th class="text-center" width="50">Stok</th>
							<th class="pl-4" width="100">Deskripsi</th>
							<th class="text-center" width="100">Harga</th>
							<th class="text-center" width="100">Aksi</th>
						</tr>
					</thead>
					<tbody>

						<?php 
						$no = $mulai+1;
						foreach ($query as $key) : 
							$sql = mysqli_query($conn, "SELECT SUM(stok) AS stok FROM warna WHERE kode_barang='$key[kode_produk]'"); 
							$stok = mysqli_fetch_array($sql);

						?>
						<tr class="">
							<td class="text-center pt-3"><?= $no++; ?></td>
							<td class="pt-3 text-center"><img width="50" height="50" src="../images/produk/<?= $key['img']; ?>" alt="<?= $key['img']; ?>"></td>
							<td class="pt-3 pl-4"><?= $key['nama']; ?></td>
							<td class="pt-3 pl-4"><?= $key['kategori']; ?></td>
							<td class="pt-3 text-center"><?= $stok['stok']; ?></td>
							<td class="pt-3 pl-4"><?= $key['deskripsi']; ?></td>
							<td class="pt-3 text-center"><?= $key['harga']; ?></td>
							<td class="pt-3 text-center">
								<a href="?id=<?= $key['id_produk']; ?>" class="badge badge-success" data-toggle="modal" data-target="#warna<?= $key['id_produk']; ?>">+ Stok Warna</a>
								<a href="?id=<?= $key['id_produk']; ?>" class="badge badge-warning" data-toggle="modal" data-target="#edit<?= $key['id_produk']; ?>">Edit</a>
								<a onClick="return confirm('apakah anda ingin menghapus data ini (kode : <?= $key['kode_produk']; ?>)?')" href="hapus.php?kode=<?= $key['kode_produk']; ?>" class="badge badge-danger">Hapus</a>
							</td>
						</tr>
						<div class="modal fade" id="warna<?= $key['id_produk']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <form action="" method="post">
						      <div class="modal-body">
						      	<?php
						      		$id = $key['id_produk']; 
						      		$kode = $key['kode_produk'];
						      	?>
							        <input type="text" name="kode" value="<?= $kode; ?>" hidden>
							        <div class="input-group mb-3">
										<div class="input-group-prepend">
										    <span class="input-group-text" id="basic-addon1">Warna</span>
										</div>
										<select class="custom-select" name="warna">
										  <option selected>-Pilih Warna-</option>
										  <?php  
										  	$sql = mysqli_query($conn, "SELECT DISTINCT warna.warna, produk.kode_produk FROM produk INNER JOIN warna ON produk.kode_produk=warna.kode_barang WHERE produk.id_produk='$id'");
										  	while($d = mysqli_fetch_assoc($sql)) {
										  ?>
											<option value="<?= $d['warna']; ?>"><?= $d['warna']; ?></option>
										  <?php } ?>
										</select>
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
										    <span class="input-group-text" id="basic-addon1">stok</span>
										</div>
										<input type="text" class="form-control" name="stok" aria-describedby="basic-addon1" required autocomplete="off">
									</div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="submit" name="addColor" class="btn btn-primary">Save changes</button>
						      </div>
						  	</form>
						    </div>
						  </div>
						</div>
						<div class="modal fade" id="edit<?= $key['id_produk']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <?php
								$id = $key['id_produk']; 
								$query_edit = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id'");
								//$result = mysqli_query($conn, $query);
								while ($row = mysqli_fetch_array($query_edit)) {  
							  ?>
						      <div class="modal-body">
						      	<form action="edit.php?id=<?= $row['id_produk']; ?>" method="post" enctype="multipart/form-data">
							        <div class="input-group mb-3">
										<div class="input-group-prepend">
										    <span class="input-group-text" id="basic-addon1">id</span>
										</div>
										<input type="text" disabled="on" class="form-control" value="<?= $row['id_produk']; ?>" name="id" aria-label="Username" aria-describedby="basic-addon1">
									</div>
							        <div class="input-group mb-3">
										<div class="input-group-prepend">
										    <span class="input-group-text" id="basic-addon1">Kode Produk</span>
										</div>
										<input type="text" class="form-control" value="<?= $row['kode_produk']; ?>" name="kode" aria-label="Username" aria-describedby="basic-addon1">
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
										    <span class="input-group-text" id="basic-addon1">Nama Produk</span>
										</div>
										<input type="text" class="form-control" value="<?= $row['nama']; ?>" name="nama" aria-label="Username" aria-describedby="basic-addon1">
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
										    <span class="input-group-text" id="basic-addon1">Stok</span>
										</div>
										<input type="text" class="form-control" value="<?= $row['stok']; ?>" name="stok" aria-label="Username" aria-describedby="basic-addon1">
									</div>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
									    <span class="input-group-text" id="basic-addon1">Kategori</span>
									  </div>
									  <select class="custom-select" name="kategori" required>
									  	  <option value="">- Pilih Kategori -</option>
										  <?php  
											$query_kategori = mysqli_query($conn, "SELECT DISTINCT kategori FROM kategori");
											while($data = mysqli_fetch_array($query_kategori)) {
										  ?>
										  <option value="<?= $data['kategori']; ?>"><?= $data['kategori']; ?></option>
										  <?php 
											}
										  ?>
									</select>
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
										    <span class="input-group-text" id="basic-addon1">Deskripsi</span>
										</div>
										<input type="text" class="form-control" value="<?= $row['deskripsi']; ?>" name="deskripsi" aria-label="Username" aria-describedby="basic-addon1">
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
										    <span class="input-group-text" id="basic-addon1">Harga</span>
										</div>
										<input type="text" class="form-control" value="<?= $row['harga']; ?>" name="harga" aria-label="Username" aria-describedby="basic-addon1">
									</div>
									<div class="input-group mb-3">
									<div class="input-group mb-3">
									  	<div class="input-group-prepend">
									    	<span class="input-group-text" id="inputGroupFileAddon01">Foto</span>
									  	</div>
									  	<div class="custom-file">
									    	<input type="file" class="custom-file-input" id="inputGroupFile01" name="file" aria-describedby="inputGroupFileAddon01">
										    <label class="custom-file-label" for="inputGroupFile01" required>Pilih Foto Produk</label>
									  	</div>
									</div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							        <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
							      </div>
							  </form>
						    </div>
							<?php } ?>
						  </div>
						</div>
						<?php 
						endforeach; 	
						?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-sm-5">
						<i class="fa fa-hand-o-right mb-3 text-secondary">&emsp;jumlah produk : <?= $total; ?></i>
					</div>
					<div class="col-sm-7">
						<nav aria-label="navigation">
						  <ul class="pagination pagination-sm">
						    <li class="page-item">
						    <?php if($_GET['halaman'] == 1) { ?>
						      <a class="page-link" disabled aria-label="Next">
						        <span aria-hidden="true">&laquo;</span>
						      </a>
						    <?php }else { ?>
						      <a class="page-link" href="?halaman=<?= $_GET['halaman'] - 1; ?>" aria-label="Next">
						        <span aria-hidden="true">&laquo;</span>
						      </a>
						    <?php } ?>
						    </li>
						    <?php
							for ($i=1; $i<=$pages ; $i++){ ?>
						    <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
						    <?php } ?>
						    <li class="page-item">
						    <?php if($_GET['halaman'] == $pages) { ?>
						      <a class="page-link" disabled aria-label="Next">
						        <span aria-hidden="true">&raquo;</span>
						      </a>
						    <?php }else { ?>
						      <a class="page-link" href="?halaman=<?= $_GET['halaman'] + 1; ?>" aria-label="Next">
						        <span aria-hidden="true">&raquo;</span>
						      </a>
						    <?php } ?>
						    </li>
						  </ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Tambah Produk</h5>
      </div>
      <form action="" method="post" enctype="multipart/form-data">
      	<?php  
      		$query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC LIMIT 1");
			$d = mysqli_fetch_array($query);
      	?>
      	<input type="text" name="id" value="<?= $d['id_produk']; ?>" hidden>
	      <div class="modal-body">
	        <div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="basic-addon1">Kode Produk</span>
			  </div>
			  <input type="text" class="form-control" name="kode" aria-label="Username" aria-describedby="basic-addon1">
			</div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="basic-addon1">Nama Produk</span>
			  </div>
			  <input type="text" class="form-control" placeholder="..." autocomplete="off" name="nama" aria-label="Username" aria-describedby="basic-addon1" required>
			</div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="basic-addon1">Kategori</span>
			  </div>
			  <select class="custom-select" name="kategori" required>
				  <option value="">- Pilih Kategori -</option>
				  <?php  
					$query_kategori = mysqli_query($conn, "SELECT DISTINCT kategori FROM kategori ORDER BY id_kategori ASC");
					while($data = mysqli_fetch_array($query_kategori)) {
				  ?>
				  <option value="<?= $data['kategori']; ?>"><?= $data['kategori']; ?></option>
				  <?php 
					}
				  ?>
			</select>
			</div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="basic-addon1">Stok</span>
			  </div>
			  <input type="number" class="form-control" placeholder="..." autocomplete="off" name="stok" aria-label="Username" aria-describedby="basic-addon1" required>
			</div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="basic-addon1">Deskripsi</span>
			  </div>
			  <input type="text" class="form-control" placeholder="..." autocomplete="off" name="deskripsi" aria-label="Username" aria-describedby="basic-addon1" required>
			</div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="basic-addon1">Harga</span>
			  </div>
			  <input type="number" class="form-control" name="harga" placeholder="..." autocomplete="off" aria-label="Username" aria-describedby="basic-addon1" required>
			</div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroupFileAddon01">Foto</span>
			  </div>
			  <div class="custom-file">
			    <input type="file" class="custom-file-input" id="inputGroupFile01" name="file" aria-describedby="inputGroupFileAddon01">
			    <label class="custom-file-label" for="inputGroupFile01">Pilih Foto Produk</label>
			  </div>
			</div>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="font-weight-bold" id="basic-addon1">Pilih Warna Produk</span>
			  </div>
			</div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="putih" type="checkbox" id="putih" value="option1">
				<label class="form-check-label" for="putih">Putih</label>
			  </div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="merah" type="checkbox" id="merah" value="option1">
				<label class="form-check-label" for="merah">Merah</label>
			  </div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="biru" type="checkbox" id="biru" value="option2">
				<label class="form-check-label" for="biru">Biru</label>
			  </div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="maroon" type="checkbox" id="maroon" value="option1">
				<label class="form-check-label" for="maroon">Maroon</label>
			  </div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="dongker" type="checkbox" id="birudongker" value="option1">
				<label class="form-check-label" for="birudongker">dongker</label>
			  </div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="hijau" type="checkbox" id="hijau" value="option2">
				<label class="form-check-label" for="hijau">Hijau</label>
			  </div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="hitam" type="checkbox" id="hitam" value="option2">
				<label class="form-check-label" for="hitam">Hitam</label>
			  </div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="abu" type="checkbox" id="abu" value="option2">
				<label class="form-check-label" for="abu">Abu</label>
			  </div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="coklat" type="checkbox" id="coklat" value="option2">
				<label class="form-check-label" for="coklat">coklat</label>
			  </div>
			  <div class="form-check form-check-inline">
				<input class="form-check-input" name="warna[]" value="kuning" type="checkbox" id="kuning" value="option2">
				<label class="form-check-label" for="kuning">Kuning</label>
			  </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
	      </div>
 	  </form>
    </div>
  </div>
</div>


