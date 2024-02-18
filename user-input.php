<?php

/**
 * REQUEST HANDLING
 */
include "sesi.php";
include "koneksi.php";
$username = $_SESSION['username'];
$query = "select id_tps from user where username='$username'";
$query2 = mysqli_query($conn, "select * from tps where id_tps =($query)");
$hasil = mysqli_fetch_array($query2);

if (!empty($_POST['id_tps'])) {
  $id_tps = $_POST['id_tps'];
  $kecamatan = $_POST['kecamatan'];
  $desa = $_POST['desa'];
  $jumlah = $_POST['jumlah'];
  $digunakan = $_POST['digunakan'];
  $tersisa = $_POST['tersisa'];
  $sah = $_POST['sah'];
  $tidaksah = $_POST['tidaksah'];
  $satu = $_POST['satu'];
  $dua = $_POST['dua'];

  $stmt = mysqli_prepare($conn, "update tps set nama_kecamatan=?, nama_desa=?, jumlah_surat=?, digunakan=?, tersisa=?, jumlah_sah=?, jumlah_tidaksah=?, calon_satu=?, calon_dua=? where id_tps=?");
  mysqli_stmt_bind_param($stmt, 'ssiiiiiiis', $kecamatan, $desa, $jumlah, $digunakan, $tersisa, $sah, $tidaksah, $satu, $dua, $id_tps);
  mysqli_stmt_execute($stmt);
  mysqli_close($conn);
  header("Location:user-index.php");
}

/**
 * TEMPLATE CALL
 */
$title = "Input Data";
include "template.php";
?>

<!-- MENU DEFINITION -->
<?php function menu()
{ ?>
  <li class="nav-item">
    <a class="nav-link" href="user-index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Home</span>
    </a>
  </li>
  <li class="nav-item active">
    <a class="nav-link" href="user-input.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Input Data</span>
    </a>
  </li>
<?php } ?>

<!-- CONTENT DEFINITION -->
<?php function content()
{
  global $hasil; 
  if (!$hasil) {
    echo "Anda tidak memiliki TPS untuk dikelola";
    return;
  }
  ?>
  <form class="container" action="user-input.php" method="post">
  <div class="form-group row">
      <label class="col-sm-3 col-form-label">ID TPS</label>
      <input class="col-sm-9 form-control" type="text" name="id_tps" value="<?php echo $hasil['id_tps'] ?>" readonly>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Nama Kecamatan</label>
      <input class="col-sm-9 form-control" type="text" name="kecamatan" placeholder="Nama Kecamatan" readonly value="<?php echo $hasil['nama_kecamatan'] ?>">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Nama Desa</label>
      <input class="col-sm-9 form-control" type="text" name="desa" placeholder="Nama Desa" readonly value="<?php echo $hasil['nama_desa'] ?>">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Jumlah Surat</label>
      <input class="col-sm-9 form-control" type="number" name="jumlah" placeholder="Jumlah Surat" value="<?php echo $hasil['jumlah_surat'] ?>">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Digunakan</label>
      <input class="col-sm-9 form-control" type="number" name="digunakan" placeholder="Digunakan" value="<?php echo $hasil['digunakan'] ?>">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Tersisa</label>
      <input class="col-sm-9 form-control" type="number" name="tersisa" placeholder="Tersisa" value="<?php echo $hasil['tersisa'] ?>">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Jumlah Sah</label>
      <input class="col-sm-9 form-control" type="number" name="sah" placeholder="Jumlah Sah" value="<?php echo $hasil['jumlah_sah'] ?>">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Jumlah Tidak Sah</label>
      <input class="col-sm-9 form-control" type="number" name="tidaksah" placeholder="Jumlah Tidak Sah" value="<?php echo $hasil['jumlah_tidaksah'] ?>">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Calon 1</label>
      <input class="col-sm-9 form-control" type="number" name="satu" placeholder="Calon 1" value="<?php echo $hasil['calon_satu'] ?>">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Calon 2</label>
      <input class="col-sm-9 form-control" type="number" name="dua" placeholder="Calon 2" value="<?php echo $hasil['calon_dua'] ?>">
    </div>
    <button class="btn btn-primary" type="submit">Edit Data</button>
  </form>
<?php } ?>