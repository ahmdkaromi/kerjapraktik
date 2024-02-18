<?php

/**
 * REQUEST HANDLING
 */
include "sesi.php";
include "koneksi.php";

if (!empty($_POST['id_tps'])) {
  $id_tps = $_POST['id_tps'];
  $kecamatan = $_POST['kecamatan'];
  $desa = $_POST['desa'];
  $stmt = mysqli_prepare($conn, "insert into tps(id_tps, nama_kecamatan, nama_desa) values (?, ?, ?)");
  mysqli_stmt_bind_param($stmt, 'sss', $id_tps, $kecamatan, $desa);
  mysqli_stmt_execute($stmt);
  $hasil = mysqli_stmt_get_result($stmt);
  if ($hasil) { ?>
    <script>
      alert("Data berhasil ditambahkan");
    </script>
<?php }
  mysqli_close($conn);
  header("Location:admin-tps.php");
}

/**
 * TEMPLATE CALL
 */
$title = "Tambah TPS";
include "template.php";
?>

<!-- MENU DEFINITION -->
<?php function menu()
{ ?>
  <li class="nav-item">
    <a class="nav-link" href="admin-index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li class="nav-item active">
    <a class="nav-link" href="admin-tps.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Data TPS</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="admin-user.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Data User</span>
    </a>
  </li>
<?php } ?>

<!-- CONTENT DEFINITION -->
<?php function content()
{ ?>
  <form class="container" action="tambah-tps.php" method="post">
    <div class="form-group row">
      <div class="col-sm-3 col-form-label">ID TPS</div>
      <input class="col-sm-9 form-control" type="text" name="id_tps" placeholder="ID TPS" required="">
    </div>
    <div class="form-group row">
      <div class="col-sm-3 col-form-label">Nama Kecamatan</div>
      <input class="col-sm-9 form-control" type="text" name="kecamatan" placeholder="Nama Kecamatan" required="">
    </div>
    <div class="form-group row">
      <div class="col-sm-3 col-form-label">Nama Desa</div>
      <input class="col-sm-9 form-control" type="text" name="desa" placeholder="Nama Desa" required="">
    </div>
    <button class="btn btn-primary" type="submit">Add Data</button>
  </form>
<?php } ?>