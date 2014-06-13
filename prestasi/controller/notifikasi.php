<?php
	if(isset($_GET['tipe'])){
		$tipe = $_GET['tipe'];
		
		switch ($tipe){
		case "jumlahNotifikasi":
			include ('prestasiController.php');
			$prestasiC = new prestasiController();
			$prestasiC->handleRequest($tipe);
			break;
		case "updateStatus":
			include ('prestasiController.php');
			$prestasiC = new prestasiController();
			$prestasiC->handleRequest($tipe);
			break;
		case "viewNotifikasi":
			include ('prestasiController.php');
			$prestasiC = new prestasiController();
			$prestasiC->handleRequest($tipe);
			break;
		default:
			//echo "Your favorite color is neither red, blue, or green!";
		}
	}
?>