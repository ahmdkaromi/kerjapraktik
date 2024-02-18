<?php
   session_start();
   include "koneksi.php";

   $username = $_POST['username'];
   $password = $_POST['password'];

   $stmt = mysqli_prepare($conn, "select * from user where username=? and password=?");
   mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
   mysqli_stmt_execute($stmt);
   $hasil = mysqli_stmt_get_result($stmt);
   $a = mysqli_fetch_array($hasil);
   if($a != NULL){
      $_SESSION['nama_user'] = $a['nama_user'];
      $_SESSION['username'] = $a['username'];
      $_SESSION['status'] = $a['status'];
      if($_SESSION['status'] == "admin"){
         header("Location:admin-index.php");
      }else{
         header("Location:user-index.php");
      }
   }else{
      header("Location:login.php");
   }
?>