<?php  

$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'pl';

$conn = mysqli_connect($host, $user, $pass, $db_name);

function alert($link, $text) {
	echo "<script>
			alert('$text');
			window.location.href='$link';
		  </script>";
}

function register($email, $pass, $nama, $tlp, $alamat) {
	global $conn;
	$query = mysqli_query($conn, "INSERT INTO users SET email='$email', password='$pass', nama='$nama', tlp='$tlp', alamat='$alamat'");
	if($query == TRUE) {
		alert('index.php', 'Registrasi Berhasil!');
	}else {
		alert('register.php', 'Registrasi Gagal!');
	}
}

function loginAdmin($user, $pass) {
	global $conn;
	$validasi = mysqli_query($conn, "SELECT * FROM admin WHERE username='$user' AND password='$pass'");
	$row = mysqli_num_rows($validasi);
		if($row > 0) {
			echo "<script>
					alert('Login Berhasil!');
					window.location.href='admin/index.php?halaman=1';
				  </script>";
		}else {
			echo "<script>
					alert('Username / Password Salah!');
					window.location.href='index.php';
				  </script>";
		}
}

function addColor($kode, $warna, $stok) {
	global $conn;
	$query = mysqli_query($conn, "UPDATE warna SET stok='$stok' where kode_barang='$kode' && warna='$warna'");
	if($query > 0) {
		alert('index.php?halaman=1', 'stok warna berhasil ditambahkan!');
	}
}


function upload() {
	$namaFile = $_FILES['file']['name'];
	$ukuranFile = $_FILES['file']['size'];
	$error = $_FILES['file']['error'];
	$tmpName = $_FILES['file']['tmp_name'];

	// cek gambar
	if($error === 4) {
		echo "<script>
				alert('Pilih gambar terlebih dahulu!');
			  </script>";
			  return false;
	}

	// yang boleh diupload hanya gambar
	$extensiValid = ['jpg', 'jpeg', 'png'];
	$extensiGambar = explode('.', $namaFile);
	$extensiGambar = strtolower(end($extensiGambar));
	if(!in_array($extensiGambar, $extensiValid)) {
		echo "<script>
				alert('yang anda upload bukan gambar!');
			  </script>";
			  return false;
	}

	// cek jika ukurannya terlalu besar
	if($ukuranFile > 1000000) {
		echo "<script>
				alert('ukuran gambar terlalu besar!');
			  </script>";
			  return false;
	}

	// lolos pengecekan
	move_uploaded_file($tmpName, '../images/produk/'. $namaFile);
	return $namaFile;

}

function tambah($kode, $nama, $kategori, $stok, $deskripsi, $harga) {
	global $conn;
	$data = mysqli_query($conn, "SELECT * FROM produk WHERE nama='$nama'");
	$rows = mysqli_num_rows($data);

	$gambar = upload();
	
	if($rows > 0) {
		echo "<script>
				alert('Menambahkan data gagal! Data sudah ada!');
				window.location.href='index.php?halaman=1';
			  </script>";
	}else {

		if(!$gambar) {
			return false;
		}

		$query = mysqli_query($conn, "INSERT INTO produk SET kode_produk='$kode', nama='$nama', kategori='$kategori', stok='$stok', deskripsi='$deskripsi', harga='$harga', img='$gambar'");

		if($query == TRUE) {
			echo "<script>
					alert('Data berhasil ditambahkan!');
					window.location.href='index.php?halaman=1';
				  </script>";
		}else {
			echo "<script>
					alert('Data gagal ditambahkan!');
					window.location.href='index.php?halaman=1';
				  </script>";
		}
	}
}

function edit($id, $kode, $nama, $kategori, $stok, $deskripsi, $harga) {
	global $conn;
	$query = mysqli_query($conn, "UPDATE produk SET kode_produk='$kode', nama='$nama', kategori='$kategori', stok='$stok', deskripsi='$deskripsi', harga='$harga' WHERE id_produk='$id'");
	if($query == TRUE) {
		echo "<script>
				alert('Data berhasil dirubah!');
				window.location.href='index.php?halaman=1';
			  </script>";
	}else {
		echo "<script>
				alert('Data gagal dirubah!');
				window.location.href='index.php?halaman=1';
			  </script>";
	}
}

function hapus($kode) {
	global $conn;
	mysqli_query($conn, "DELETE FROM produk WHERE kode_produk='$kode'");
	return mysqli_affected_rows($conn);
}

function tambah_kategori($kategori) {
	global $conn;
	$data = mysqli_query($conn, "SELECT * FROM kategori WHERE kategori='$kategori'");
	$rows = mysqli_num_rows($data);
	if($rows > 0) {
		echo "<script>
				alert('Data ini sudah ada!');
			  </script>";
	}else {
		$query = mysqli_query($conn, "INSERT INTO kategori SET kategori='$kategori'");
		if($query == true) {
			echo "<script>
					alert('Kategori Berhasil ditambahkan!');
					window.location.href='kategori.php';
			  	  </script>";
		}else {
			echo "<script>
					alert('Gagal ditambahkan!');
					window.location.href='kategori.php';
		 	  	  </script>";
		}
	}
}

function hapus_kategori($id) {
	global $conn;
	mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori='$id'");
	return mysqli_affected_rows($conn);
}

function edit_kategori($id, $kategori) {
	global $conn;
	$data = mysqli_query($conn, "SELECT * FROM kategori WHERE kategori='$kategori'");
	$rows = mysqli_num_rows($data);
	if($rows == 0) {
		$query = mysqli_query($conn, "UPDATE kategori SET kategori='$kategori' WHERE id_kategori='$id'");
		if($query == true) {
			echo "<script>
					alert('Kategori Berhasil di Edit!');
					window.location.href='kategori.php';
			  	  </script>";
		}else {
			echo "<script>
					alert('Gagal di sEdit!');
					window.location.href='kategori.php';
		 	  	  </script>";
		}
	}else {
		echo "<script>
				alert('Gagal di Edit! Data sudah ada!');
				window.location.href='kategori.php';
		 	  </script>";
	}
}

function loginUser($email, $pass) {
	global $conn;
	$query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$pass'");
	$array = mysqli_fetch_assoc($query);

	if($row = mysqli_num_rows($query) > 0) {
		$nama = $array['nama'];
		$_SESSION['id_user'] = $array['id_user'];
		$_SESSION['nameCustomer'] = $nama;
		$_SESSION['statusCustomer'] = 'login';
		alert('index.php', 'Login Berhasil!');
	}else {
		alert('login.php', 'Username / Password Salah!');
	}
}


?>