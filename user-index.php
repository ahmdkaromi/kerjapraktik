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

/**
 * TEMPLATE CALL
 */
$title = "Home";
include "template.php";
?>

<!-- MENU DEFINITION -->
<?php function menu() {?>
   <li class="nav-item active">
      <a class="nav-link" href="user-index.php">
         <i class="fas fa-fw fa-tachometer-alt"></i>
         <span>Home</span>
      </a>
   </li>
   <li class="nav-item">
      <a class="nav-link" href="user-input.php">
         <i class="fas fa-fw fa-tachometer-alt"></i>
         <span>Input Data</span>
      </a>
   </li>
<?php }?>

<!-- CONTENT DEFINITION -->
<?php function content() {
   global $hasil; 
   if (!$hasil) {
     echo "Anda tidak memiliki TPS untuk dikelola";
     return;
   }
   ?>
   <h3>Perolehan Suara TPS <?= $hasil['id_tps'] ?> - <?= $hasil['nama_desa'] ?>, <?= $hasil['nama_kecamatan'] ?></h3>
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