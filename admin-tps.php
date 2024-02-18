<?php

/**
 * REQUEST HANDLING
 */
include "sesi.php";
include "koneksi.php";
$number = 1;
$query = mysqli_query($conn, "select * from tps");
$data = mysqli_fetch_array($query);

if (!empty($_GET['id_tps'])) {
    $id_tps = $_GET['id_tps'];

    $stmt = mysqli_prepare($conn, "delete from tps where id_tps=?");
    mysqli_stmt_bind_param($stmt, 'i', $id_tps);
    mysqli_stmt_execute($stmt);
    mysqli_close($conn);
    header("Location:admin-tps.php");
}

/**
 * TEMPLATE CALL
 */
$title = "Data TPS";
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
{
    global $query, $number;
?>
    <a href="tambah-tps.php" class="btn btn-success mb-3">Tambah</a>
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID TPS</th>
                    <th>Kecamatan</th>
                    <th>Desa</th>
                    <th>Jumlah Surat</th>
                    <th>Digunakan</th>
                    <th>Tersisa</th>
                    <th>Sah</th>
                    <th>Tidak Sah</th>
                    <th>Paslon 1</th>
                    <th>Paslon 2</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($query as $row) { ?>
                    <tr>
                        <th><?php echo $number ?></th>
                        <td><?php echo $row['id_tps'] ?></td>
                        <td><?php echo $row['nama_kecamatan'] ?></td>
                        <td><?php echo $row['nama_desa'] ?></td>
                        <td><?php echo $row['jumlah_surat'] ?></td>
                        <td><?php echo $row['digunakan'] ?></td>
                        <td><?php echo $row['tersisa'] ?></td>
                        <td><?php echo $row['jumlah_sah'] ?></td>
                        <td><?php echo $row['jumlah_tidaksah'] ?></td>
                        <td><?php echo $row['calon_satu'] ?></td>
                        <td><?php echo $row['calon_dua'] ?></td>
                        <td><a href='<?php echo "edit-tps-baru.php?id_tps=" . $row['id_tps']; ?>'> Edit </a> /
                        <a onclick="hapus('<?= $row['id_tps'] ?>')" href="#" data-toggle="modal" data-target="#deleteModal"> Hapus </a>
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
<?php function scripts()
{ ?>
    <script>
        function hapus(id) {
            document.querySelector("#link_hapus").href = "admin-tps.php?id_tps=" + id;
        }
    </script>
<?php } ?>