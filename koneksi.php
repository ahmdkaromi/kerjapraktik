<?php
   error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
   $conn = mysqli_connect("localhost", "root", "", "kp") or die("connection failed");
?>