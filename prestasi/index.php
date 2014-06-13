<?php
//error_reporting(0);
session_start();
include ('controller/aksesController.php');
$akses = new aksesController();

//mengecek tombol logout diklik
if(isset($_GET['logout'])){
	$akses->logout();  
}
else{
	$akses->cekSesi();
}
?>