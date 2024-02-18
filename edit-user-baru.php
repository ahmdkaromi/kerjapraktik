<?php

/**
 * REQUEST HANDLING
 */
include "sesi.php";
include "koneksi.php";
$query = mysqli_query($conn, "select * from user");
$hasil = mysqli_fetch_array($query);

$query_tps = mysqli_query($conn, "SELECT * FROM tps");
$hasil_tps = mysqli_fetch_all($query_tps, MYSQLI_ASSOC);

if (!empty($_GET['id_user'])) {
  $id_user = $_GET['id_user'];

  $stmt = mysqli_prepare($conn, "select * from user where id_user=?");
  mysqli_stmt_bind_param($stmt, 'i', $id_user);
  mysqli_stmt_execute($stmt);
  $hasil = mysqli_fetch_array(mysqli_stmt_get_result($stmt));
}

if (!empty($_POST['id_user'])) {
  $id_user = $_POST['id_user'];
  $nama = $_POST['nama'];
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $status = $_POST['status'];
  $tps = $_POST['tps'];

  if ($tps) {
    $stmt = mysqli_prepare($conn, "update user set nama_user=?, username=?, password=?, status=?, id_tps=? where id_user=?");
    mysqli_stmt_bind_param($stmt, 'sssssi', $nama, $user, $pass, $status, $tps, $id_user);
  }
  else {
    $stmt = mysqli_prepare($conn, "update user set nama_user=?, username=?, password=?, status=?, id_tps=NULL where id_user=?");
    mysqli_stmt_bind_param($stmt, 'ssssi', $nama, $user, $pass, $status, $id_user);
  }
  mysqli_stmt_execute($stmt);
  mysqli_close($conn);
  header("Location:admin-user.php");
}

/**
 * TEMPLATE CALL
 */
$title = "Edit User";
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
  global $hasil, $hasil_tps; ?>
  <form class="container" action="edit-user-baru.php" method="post">
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">ID User</label>
      <input class="col-sm-9 form-control" type="text" name="id_user" value="<?php echo $hasil['id_user'] ?>" placeholder="Nama User" readonly>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Nama User</label>
      <input class="col-sm-9 form-control" type="text" name="nama" value="<?php echo $hasil['nama_user'] ?>" placeholder="Nama User" required="">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Username</label>
      <input class="col-sm-9 form-control" type="text" name="user" value="<?php echo $hasil['username'] ?>" placeholder="Username" required="">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Password</label>
      <input class="col-sm-9 form-control" type="password" name="pass" value="<?php echo $hasil['password'] ?>" placeholder="Password" required="">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">Status</label>
      <input class="col-sm-9 form-control" type="text" name="status" value="<?php echo $hasil['status'] ?>" placeholder="Status" required="">
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label">ID TPS</label>
      <select class="col-sm-9 form-control" name="tps">
        <option value="">Pilih</option>
        <?php foreach ($hasil_tps as $row) { ?>
          <option value="<?= $row['id_tps'] ?>"  <?= $hasil['id_tps'] == $row['id_tps'] ? 'selected' : '' ?>><?= $row['id_tps'] ?> - <?= $row['nama_desa'] ?>, <?= $row['nama_kecamatan'] ?></option>
        <?php }?>
      </select>
    </div>
    <button class="btn btn-primary" type="submit">Edit Data</button>
  </form>
<?php } ?>