<!DOCTYPE html>
<html lang="en">
  <head>
  <title>Halaman Notifikasi Prestasi</title>
  </head>
  
  <body>
  <table class='table'>
	<tr bgcolor="#F9F9F9">
		<th>No</th>
		<th>BP</th>
		<th>Mahasiswa</th>
		<th>Fakultas/UKM</th>
		<th>Prestasi</th>
	</tr>
	<?php 
		include ("../controller/prestasiController.php");
		$prestasiC = new prestasiController();
		$prestasiC->handleRequest("viewNotifikasi");
	?>
  </table>
  </body>
  
</html> 