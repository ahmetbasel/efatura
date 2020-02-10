<?php 
session_start();
$kontrol = $_SESSION['username'];
if ($kontrol==null)
	header("Location: ../login.php"); 
?>