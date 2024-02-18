<?php
   include "sesi.php";
   session_unset();
   session_destroy();
   header("Location:login.php");
?>