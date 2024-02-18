<?php

session_start();
error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_SESSION['username'])) {
    header("Location:login.php");
}
?>