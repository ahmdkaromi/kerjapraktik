<?php

/**
 * REQUEST HANDLING
 */
include "sesi.php";
include "koneksi.php";
if (!empty($_POST['nama'])) {
  $nama = $_POST['nama'];
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $status = $_POST['status'];
  $tps = $_POST['tps'];
  if (!$tps) {
    $stmt = mysqli_prepare($conn, "insert into user(nama_user, username, password, status) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $nama, $user, $pass, $status);    
  } else {
    $stmt = mysqli_prepare($conn, "insert into user(nama_user, username, password, status, id_tps) values (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sssss', $nama, $user, $pass, $status, $tps);
  }
  mysqli_stmt_execute($stmt);
  $hasil = mysqli_stmt_get_result($stmt);
  if ($hasil) { ?>
    <script>
      alert("Data berhasil ditambahkan");
    </script>
<?php }
  mysqli_close($conn);
  header("Location:admin-user.php");
}

$query = mysqli_query($conn, "SELECT * FROM tps");
$hasil = mysqli_fetch_all($query, MYSQLI_ASSOC);

/**
 * TEMPLATE CALL
 */
$title = "Tambah User";
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
  <li class="nav-item">
    <a class="nav-link" href="admin-tps.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Data TPS</span>
    </a>
  </li>
  <li class="nav-item active">
    <a class="nav-link" href="admin-user.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Data User</span>
    </a>
  </li>
<?php } ?>

<!-- CONTENT DEFINITION -->
<?php function content()
{ 
  global $hasil; ?>
  <form class="container" action="tambah-user.php" method="post">
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Nama User</label>
      <input class="col-sm-9 form-control" type="text" name="nama" placeholder="Nama User" required="">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Username</label>
      <input class="col-sm-9 form-control" type="text" name="user" placeholder="Username" required="">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Password</label>
      <input class="col-sm-9 form-control" type="password" name="pass" placeholder="Password" required="">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Status</label>
      <input class="col-sm-9 form-control" type="text" name="status" placeholder="Status" required="">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">ID TPS</label>
      <select class="col-sm-9 form-control" name="tps">
        <option value="">Pilih</option>
        <?php foreach ($hasil as $row) { ?>
          <option value="<?= $row['id_tps'] ?>"><?= $row['id_tps'] ?> - <?= $row['nama_desa'] ?>, <?= $row['nama_kecamatan'] ?></option>
        <?php }?>
      </select>
    </div>
    <button class="btn btn-primary" type="submit">Add Data</button>
  </form>
<?php } ?>