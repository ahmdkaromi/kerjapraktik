<?php
/**
 * REQUEST HANDLING
 */
include "sesi.php";
include "koneksi.php";

$query = mysqli_query($conn, "select SUM(jumlah_surat) AS jumlah_surat, SUM(digunakan) AS digunakan, SUM(tersisa) AS tersisa, SUM(jumlah_sah) AS jumlah_sah, SUM(jumlah_tidaksah) AS jumlah_tidaksah, SUM(calon_satu) AS calon_satu, SUM(calon_dua) AS calon_dua from tps");
$hasil = mysqli_fetch_array($query);

/**
 * TEMPLATE CALL
 */
$title = "Dashboard Admin";
include "template.php";
?>

<!-- MENU DEFINITION -->
<?php function menu() {?>
   <li class="nav-item active">
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
   <li class="nav-item">
      <a class="nav-link" href="admin-user.php">
         <i class="fas fa-fw fa-tachometer-alt"></i>
         <span>Data User</span>
      </a>
   </li>
<?php }?>

<!-- CONTENT DEFINITION -->
<?php function content() {
   global $hasil; 
   ?>
   <h3>Perolehan Suara Keseluruhan</h3>
   <div class="row">
      <div class="col-md-6">
         <canvas id="myChart" style="width:100%;max-width:400px"></canvas>
      </div>
      <div class="col-md-6">
         <table class="table table-bordered">
            <tr>
               <th>Jumlah Surat</th>
               <td><?= $hasil['jumlah_surat']; ?></td>
            </tr>
            <tr>
               <th>Surat Digunakan</th>
               <td><?= $hasil['digunakan']; ?></td>
            </tr>
            <tr>
               <th>Surat Tersisa</th>
               <td><?= $hasil['tersisa']; ?></td>
            </tr>
            <tr>
               <th>Suara Sah</th>
               <td><?= $hasil['jumlah_sah']; ?></td>
            </tr>
            <tr>
               <th>Suara Tidak Sah</th>
               <td><?= $hasil['jumlah_tidaksah']; ?></td>
            </tr>
            <tr>
               <th>Calon Satu</th>
               <td><?= $hasil['calon_satu']; ?></td>
            </tr>
            <tr>
               <th>Calon Dua</th>
               <td><?= $hasil['calon_dua']; ?></td>
            </tr>
         </table>
      </div>
   </div>
<?php }?>

<!-- ADDITIONAL SCRIPT -->
<?php function scripts() { 
   global $hasil; 
   ?>
<script>
   var xValues = ["Calon Satu", "Calon Dua"];
	var yValues = [<?= $hasil['calon_satu'] ?>, <?= $hasil['calon_dua'] ?>];
	var barColors = [
	  "#943030",
	  "#007DF0",
	];
	
	new Chart("myChart", {
	  type: "pie",
	  data: {
		labels: xValues,
		datasets: [{
		  backgroundColor: barColors,
		  data: yValues
		}]
	  }
	});
</script>
<?php } ?>