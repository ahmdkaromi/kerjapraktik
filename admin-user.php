<?php

/**
 * REQUEST HANDLING
 */
include "sesi.php";
include "koneksi.php";
$number = 1;
$query = mysqli_query($conn, "select * from user");
$data = mysqli_fetch_array($query);

if (!empty($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    $stmt = mysqli_prepare($conn, "delete from user where id_user=?");
    mysqli_stmt_bind_param($stmt, 'i', $id_user);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    header("Location:admin-user.php");
}

/**
 * TEMPLATE CALL
 */
$title = "Data User";
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
    global $query, $number;
?>
    <a href="tambah-user.php" class="btn btn-success mb-3">Tambah</a>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
                <tr>
                    <th>No.</th>
                    <th>ID User</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>ID TPS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($query as $row) { ?>
                    <tr>
                        <th><?php echo $number ?></th>
                        <td><?php echo $row['id_user'] ?></td>
                        <td><?php echo $row['nama_user'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['password'] ?></td>
                        <td><?php echo $row['status'] ?></td>
                        <td><?php echo $row['id_tps'] ?></td>
                        <td><a href='<?php echo "edit-user-baru.php?id_user=" . $row['id_user']; ?>'> Edit </a> /
                            <a onclick="hapus('<?= $row['id_user'] ?>')" href="#" data-toggle="modal" data-target="#deleteModal"> Hapus </a>
                        </td>
                    </tr>
                <?php $number++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">Yakin menghapus data ini?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a id="link_hapus" class="btn btn-primary" href="">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- ADDITIONAL SCRIPT -->
<?php function scripts() {?>
<script>
   function hapus(id) {
    document.querySelector("#link_hapus").href = "admin-user.php?id_user=" + id;
   }
</script>
<?php } ?>